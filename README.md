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

```php
$email = new Email();
$email->populateTemplate([
    'Callout' => 'Here is my callout',
    'Sidebar' => 'Here is my sidebar',
    'HeroImage' => Image::get()->first()
]);
```

A default Header and Footer is provided:

- The header display the logo or the title of the website
- The footer display the social medias links and a user defined text in the SiteConfig

Make it your own styles
==================

The templates are divided in various include which allow you to easily make them
fit your styles.

To define your base styles, override FoundationEmailStyles.ss.

To define your own headers and footers, override FoundationEmailFooter and FoundationEmailHeader.

Consistent ChangePassword and ForgotPassword templates
==================

These default templates have been overriden. They are not stored in the /email folder
otherwise the framework version will be picked instead of this one.

NOTE : we include a button to reset the password instead of a plain link. The translation
is NOT provided by the framework, make sure to define one (ForgotPasswordEmail_ss.TEXTBTN)

Create new emails
==================

As explained in the [SilverStripe documentation] (https://docs.silverstripe.org/en/3.3/developer_guides/email/) you can create
subclasses of the Email class.

An example class has been provided called WelcomeEmail.

Testing emails
==================

For your convenience, a task called "Email Viewer Task" has been provided.

This task allow you to select any subclass of the Email class and see its html (preview and code).

You can also set the locale and inline styles (require pelago/emogrifier) for better testing.

Compatibility
==================
Tested with 3.x

Maintainer
==================
LeKoala - thomas@lekoala.be