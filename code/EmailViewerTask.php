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

        DB::alteration_message("You can set the locale by passing ?locale=fr_FR. Current locale is ".i18n::get_locale());
        DB::alteration_message("You can inline css styles by passing ?inline=1");

        $refl            = new ReflectionClass($email);
        $constructorOpts = $refl->getConstructor()->getParameters();

        $args = array();

        if (!empty($constructorOpts)) {
            /* @var $opt ReflectionParameter  */
            foreach ($constructorOpts as $opt) {
                $type = $opt->getClass()->getName();
                if (class_exists($type) && in_array($type, ClassInfo::subclassesFor('DataObject'))) {
                    $record = $type::get()->first();
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
            $e->setBody("<p class='lead'>Phasellus ultrices nulla quis nibh. Quisque a lectus.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>");
            $e->populateTemplate([
                'Callout' => "<ol>
   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
   <li>Aliquam tincidunt mauris eu risus.</li>
   <li>Vestibulum auctor dapibus neque.</li>
</ol>",
                'Sidebar' => '<nav>
	<ul>
		<li><a href="#">Home</a></li>
		<li><a href="#">About</a></li>
		<li><a href="#">Clients</a></li>
		<li><a href="#">Contact Us</a></li>
	</ul>
</nav>',
                'HeroImage' => Image::get()->first()
            ]);
        }
        $e->populateTemplate(Member::currentUser());
        $e->debug(); // Call debug to trigger parseVariables

        if ($inline) {
            if (!class_exists("\\Pelago\\Emogrifier")) {
                throw new Exception("You must run composer require pelago/emogrifier:@dev");
            }
            $emogrifier = new \Pelago\Emogrifier();
            $emogrifier->setHtml($e->body);
            $emogrifier->disableInvisibleNodeRemoval();
            $body       = $emogrifier->emogrify();
        } else {
            $body = $e->body;
        }


        echo '<hr/><center>Subject : '.$e->subject.'</center>';
        echo '<hr/>';
        echo $body;
        echo '<hr/><pre style="font-size:12px;line-height:12px;">';
        echo htmlentities($body);
        echo '</pre>';
    }
}