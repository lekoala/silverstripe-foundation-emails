SilverStripe Foundation Emails module
==================
Replace the default html template by one made with [Foundation Emails] (http://foundation.zurb.com/emails/docs/css-guide.html).

The email templates use zurb/foundation-emails (v 2.2.1) to provide a consistent markup.

Expanded generic emails
==================

The generic email comes with a few new options:

- If you define a Callout, it will be displated as a callout
- If you define a Sidebar, a right sidebar will be displayed (ratio 7/5)
- If you define a HeroImage (an Image object), it will be displayed below the body and before the callout

    $email = new Email();
    $email->populateTemplate([
        'Callout' => 'Here is my callout',
        'Sidebar' => 'Here is my sidebar',
        'HeroImage' => Image::get()->first()
    ]);

A default Header and Footer is provided:

- The header display the logo or the title of the website
- The footer display the social medias links and a user defined text in the SiteConfig

In the footer, social medias links should be provided through the EmailFooterLinks method
on the SiteConfig. Each item consist of a : Class, Link, Label and Icon.

Template helpers
==================

Instead of relying on specific markup, you can also use template helpers directly
in your email templates. For instance:

    $email = new Email();
    $viewer = new SSViewer('MyEmailTemplate');
    $result = $viewer->process($this);
    $email->setBody((string) $result);

    Dear Customer,<br/><br/>
    Please find your password reset link:<br/><br/>
    $FoundationButton('Reset your passowrd', $PasswordResetLink)

Available helpers are:

- FoundationSpacer
- FoundationButton
- FoundationCallout
- FoundationContainer

Make it your own styles
==================

The templates are divided in various include which allow you to easily make them
fit your styles.

To define your base styles, override FoundationEmailStyles.ss.

To define your own headers and footers, override FoundationEmailFooter and FoundationEmailHeader.

Two other styles are provided : "vision" and "ceej". Feel free to use the one you like the most.
You can select your theme by applying the following config.

    FoundationEmails:
      theme: 'vision'

Consistent ChangePassword and ForgotPassword templates
==================

These default templates have been overriden.

NOTE : we include a button to reset the password instead of a plain link.

Create new emails
==================

As explained in the [SilverStripe documentation] (https://docs.silverstripe.org/en/4/developer_guides/email/) you can create
subclasses of the Email class.

An example class has been provided called WelcomeEmail.

Testing emails
==================

For your convenience, a task called "Email Viewer Task" has been provided.

This task allow you to select any subclass of the Email class and see its html (preview and code).

You can also set the locale and inline styles (require pelago/emogrifier) for better testing.

If your emails require constructor arguments that are DataObjects, random records
from your database will be injected. If you want to inject specific records, pass
ClassNameID=YourID as GET parameters (for instance MemberID=5).

Compatibility
==================
Tested with 4.1+

Maintainer
==================
LeKoala - thomas@lekoala.be
