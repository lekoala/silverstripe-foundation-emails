<?php

/**
 * A task to help testing and previewing emails
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class EmailViewerTask extends BuildTask
{
    protected $title       = "Email Viewer Task";
    protected $description = 'Helps you previewing and testing emails';

    /**
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        $email  = $request->getVar('email');
        $locale = $request->getVar('locale');
        $inline = $request->getVar('inline');
        $to     = $request->getVar('to');

        if (!$email) {
            $emailClasses = ClassInfo::subclassesFor('Email');
            DB::alteration_message("Please select an email to test or preview");
            foreach ($emailClasses as $class) {
                $link = '/dev/tasks/EmailViewerTask?email='.$class;
                DB::alteration_message("<a href='$link'>$class</a>");
            }
            return;
        }

        if ($locale) {
            i18n::set_locale($locale);
        }

        if ($locale) {
            DB::alteration_message("Locale is set to ".$locale, "created");
        } else {
            DB::alteration_message("You can set the locale by passing ?locale=fr_FR. Current locale is ".i18n::get_locale());
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
                DB::alteration_message("Email sent to ".$member->Email,
                    'created');
            } else {
                $member = null;
                DB::alteration_message("Member not found", "error");
            }
        } else {
            DB::alteration_message("You can send this email by passing ?to=email_of_the@member.com");
        }

        $refl            = new ReflectionClass($email);
        $constructorOpts = $refl->getConstructor()->getParameters();

        $args = [];

        if (!empty($constructorOpts)) {
            /* @var $opt ReflectionParameter  */
            foreach ($constructorOpts as $opt) {
                $cl = $opt->getClass();
                if (!$cl) {
                    continue;
                }
                $type = $opt->getClass()->getName();
                if (class_exists($type) && in_array($type,
                        ClassInfo::subclassesFor('DataObject'))) {

                    // We can get record based on an ID passed in the URL
                    $recordID = $request->getVar($type.'ID');
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

        // For a generic email, we should set some content...
        if ($email == 'Email') {
            $e->setSubject("Generic email");

            $body = "<p class='lead'>Phasellus ultrices nulla quis nibh. Quisque a lectus.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>";
            $body .= FoundationEmails::button('Click here', '#', 'brand');
            
            $e->setBody($body);

            $image = Image::get()->sort('RAND()')->first();

            $data = [
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

            $e->populateTemplate($data);
        }

        if (!$member) {
            if (Member::currentUserID()) {
                $member = Member::currentUser();
            } else {
                $member = Member::get()->sort('RAND()')->first();
            }
        }
        if ($member) {
            $e->populateTemplate($member);
        }
        $e->debug(); // Call debug to trigger parseVariables

        if ($inline) {
            if (!class_exists("\\Pelago\\Emogrifier")) {
                throw new Exception("You must run composer require pelago/emogrifier");
            }
            $emogrifier = new \Pelago\Emogrifier();
            $emogrifier->setHtml($e->body);
            $emogrifier->disableInvisibleNodeRemoval();
            $emogrifier->enableCssToHtmlMapping();
            $body       = $emogrifier->emogrify();

            $e->setBody($body);
        } else {
            $body = $e->body;
        }

        if ($member && $to) {
            $e->setTo($member->Email);
            $result = $e->send();
            echo '<hr/>';
            if ($result) {
                echo '<span style="color:green">Email sent</span>';
            } else {
                echo '<span style="color:red">Failed to send email</span>';
            }
        }

        echo '<hr/><center>Subject : '.$e->subject.'</center>';
        echo '<hr/>';
        echo $body;
        echo '<hr/><pre style="font-size:12px;line-height:12px;">';
        echo htmlentities($body);
        echo '</pre>';
    }
}