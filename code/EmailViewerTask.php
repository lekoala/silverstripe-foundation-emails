<?php

use SilverStripe\ORM\DB;
use SilverStripe\Dev\Debug;
use SilverStripe\i18n\i18n;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * A task to help testing and previewing emails
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class EmailViewerTask extends BuildTask
{
    private static $segment = 'EmailViewerTask';

    const FORGOT_PASSWORD_TEMPLATE = 'SilverStripe\\Control\\Email\\ForgotPasswordEmail';
    const CHANGE_PASSWORD_TEMPLATE = 'SilverStripe\\Control\\Email\\ChangePasswordEmail';

    protected $title = "Email Viewer";
    protected $description = 'Helps you previewing and testing emails';

    /**
     *
     * @param HTTPRequest $request
     */
    public function run($request)
    {
        $email = $request->getVar('email');
        $locale = $request->getVar('locale');
        $template = $request->getVar('template');
        $inline = $request->getVar('inline');
        $to = $request->getVar('to');
        $force_theme = $request->getVar('force_theme');

        if (!$email) {
            $emailClasses = ClassInfo::subclassesFor(Email::class);
            DB::alteration_message("Please select an email to test or preview");
            foreach ($emailClasses as $class) {
                $link = '/dev/tasks/EmailViewerTask?email=' . urlencode($class);
                DB::alteration_message("<a href='$link'>$class</a>");
                if ($class == Email::class) {
                    DB::alteration_message("<a href='$link&force_theme=none'>$class (default styles)</a>");
                    DB::alteration_message("<a href='$link&force_theme=ceej'>$class (ceej styles)</a>");
                    DB::alteration_message("<a href='$link&force_theme=vision'>$class (vision styles)</a>");
                    DB::alteration_message("<a href='$link&template=" . urlencode(self::FORGOT_PASSWORD_TEMPLATE) . "'>$class (ForgotPassword)</a>");
                    DB::alteration_message("<a href='$link&template=" . urlencode(self::CHANGE_PASSWORD_TEMPLATE) . "'>$class (ChangePassword)</a>");
                }
            }
            return;
        }

        if ($force_theme) {
            Config::modify()->set(FoundationEmails::class, 'theme', $force_theme);
        }
        if ($locale) {
            i18n::set_locale($locale);
        }

        if ($locale) {
            DB::alteration_message("Locale is set to " . $locale, "created");
        } else {
            DB::alteration_message("You can set the locale by passing ?locale=fr_FR. Current locale is " . i18n::get_locale());
        }
        if ($inline) {
            DB::alteration_message("Css are inlined", "created");
        } else {
            DB::alteration_message("You can inline css styles by passing ?inline=1");
        }
        $member = null;
        if ($to) {
            $member = Member::get()->filter('Email', $to)->first();
            if ($member && $member->ID) {
                DB::alteration_message(
                    "Email sent to " . $member->Email,
                    'created'
                );
            } else {
                $member = new Member();
                $member->Email = $to;
                $member->FirstName = 'John';
                $member->Surname = 'Smith';
                DB::alteration_message("A temporary member has been created with email " . $member->Email, "changed");
            }
        } else {
            DB::alteration_message("You can send this email by passing ?to=email_of_the@member.com");
        }

        $refl = new ReflectionClass($email);
        $constructorOpts = $refl->getConstructor()->getParameters();

        $args = [];

        if (!empty($constructorOpts)) {
            /* @var $opt ReflectionParameter  */
            foreach ($constructorOpts as $opt) {
                $cl = $opt->getClass();
                if (!$cl) {
                    continue;
                }
                // We can inject DataObject as parameters
                $type = $opt->getClass()->getName();
                if (class_exists($type) && in_array(
                    $type,
                    ClassInfo::subclassesFor(DataObject::class)
                )) {
                    // We can get record based on an ID passed in the URL
                    $recordID = $request->getVar($type . 'ID');
                    if ($recordID) {
                        $record = $type::get()->byID($recordID);
                    } else {
                        $record = $type::get()->sort('RAND()')->first();
                    }
                    if (!$record) {
                        $record = new $type;
                    }
                    $args[] = $record;
                }
            }
        }

        /* @var $e Email */
        $e = $refl->newInstanceArgs($args);

        if ($template) {
            DB::alteration_message("Using template $template");
            $e->setHTMLTemplate($template);
        }

        // For a generic email, we should set some content...
        if ($email == Email::class) {
            DB::alteration_message("Injecting some random content to default email");
            $e = $this->setDefaultEmailContent($e);
        }

        // Inject a member
        if (!$member) {
            if (Member::currentUserID()) {
                $member = Member::currentUser();
            } else {
                $member = Member::get()->sort('RAND()')->first();
            }
        }
        if ($member) {
            $e->addData($member->toMap());
        }

        // Call debug to trigger parseVariables
        $debugData = $e->debug();

        if ($inline) {
            // We can use setBody because template has been applied
            $body = $this->inlineContent($e->body);
            $e->setBody($body);
        } else {
            $body = $e->body;
        }

        if ($member && $to) {
            try {
                $e->setTo($member->Email, $member->getTitle());
                $result = $e->send();
                echo '<hr/>';
                if ($result) {
                    echo '<span style="color:green">Email sent : ' . json_encode($result) . '</span>';
                } else {
                    echo '<span style="color:red">Failed to send email</span>';
                }
            } catch (Exception $ex) {
                echo '<span style="color:red">' . $ex->getMessage() . '</span>';
            }
        }

        echo '<hr/><center>Subject : ' . $e->subject . '</center>';
        echo '<hr/>';
        echo $body;
        echo '<hr/><pre style="font-size:12px;line-height:12px;">';
        echo htmlentities($body);
        echo '</pre>';

        Debug::show($e);
    }

    /**
     * @param string $body
     * @return string
     */
    protected function inlineContent($body)
    {
        if (!class_exists(\Pelago\Emogrifier\CssInliner::class)) {
            throw new Exception("You must run composer require pelago/emogrifier");
        }
        $domDocument = \Pelago\Emogrifier\CssInliner::fromHtml($body)->inlineCss()->getDomDocument();

        \Pelago\Emogrifier\HtmlProcessor\HtmlPruner::fromDomDocument($domDocument)->removeElementsWithDisplayNone();
        $html = \Pelago\Emogrifier\HtmlProcessor\CssToAttributeConverter::fromDomDocument($domDocument)
            ->convertCssToVisualAttributes()->render();

        return $html;
    }

    /**
     * @param Email $e
     * @return Email
     */
    protected function setDefaultEmailContent(Email $e)
    {
        $e->setSubject("Generic email");

        $body = "<p class='lead'>Phasellus ultrices nulla quis nibh. Quisque a lectus.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>";
        $body .= FoundationEmails::button('Click here', '#', 'brand');

        // Do not use SetBody as it will prevent template usage
        $e->addData('EmailContent', $body);

        $image = Image::get()->sort('RAND()')->first();

        $data = [
            'PreHeader' => 'This text is only visible in your email client...',
            'Callout' => '<h2>Quisque a lectus</h2>
<ol>
<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
<li>Aliquam tincidunt mauris eu risus.</li>
<li>Vestibulum auctor dapibus neque.</li>
</ol>
<a href="#">Phasellus ultrices nulla</a>',
            'SecondaryCallout' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit?</p>
<a href="#">Vestibulum auctor</a>',
            'Sidebar' => '<nav>
<ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Clients</a></li>
    <li><a href="#">Contact Us</a></li>
</ul>
</nav>'
        ];
        if ($image) {
            $data['HeroImage'] = $image;
        }

        // Let's add an email footer
        $sc = SiteConfig::current_site_config();
        if (!$sc->EmailFooter) {
            $sc->EmailFooter = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.';
        }
        if (!$sc->Copyright) {
            $sc->Copyright = '© ' . date('Y') . ' - ' . $sc->Title . ' - All Rights Reserved.';
        }
        if (!$sc->EmailFooterLinks) {
            $sc->EmailFooterLinks = new ArrayList([
                [
                    'Class' => 'twitter',
                    'Link' => '#',
                    'Label' => 'Twitter',
                    'Icon' => '/resources/foundation-emails/images/icon_twitter.png'
                ],
                [
                    'Class' => 'facebook',
                    'Link' => '#',
                    'Label' => 'Facebook',
                    'Icon' => '/resources/foundation-emails/images/icon_facebook.png'
                ],
                [
                    'Class' => 'google',
                    'Link' => '#',
                    'Label' => 'Google',
                    'Icon' => '/resources/foundation-emails/images/icon_google.png'
                ],
            ]);
        }

        // Password emails data
        $data['PasswordResetLink'] = '/some/reset/link';

        $e->addData($data);

        return $e;
    }
}
