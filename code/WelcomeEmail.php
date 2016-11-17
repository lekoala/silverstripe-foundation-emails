<?php

/**
 * A generic welcome email
 *
 * @author LeKoala <thomas@lekoala.be>
 */
class WelcomeEmail extends Email
{
    protected $ss_template = "WelcomeEmail";

    public function __construct($member = null)
    {
        $member = $member ? $member : Member::currentUser();

        $link = Director::absoluteBaseUrl();
        $host = parse_url($link, PHP_URL_HOST);

        $this->subject = _t('WelcomeEmail.SUBJECT', "Welcome to {Website}",
            'Email subject',
            ['Website' => SiteConfig::current_site_config()->Title]);

        if ($member) {
            $this->to = $member->Email;
            if ($member->FirstName) {
                $name     = trim($member->FirstName.' '.$member->Surname);
                $this->to = $name.' <'.$member->Email.'>';
            }
        }

        parent::__construct();

        $this->populateTemplate(new ArrayData([
            'Member' => $member,
            'AbsoluteWebsiteLink' => $link,
            'WebsiteLink' => $host,
        ]));
    }
}