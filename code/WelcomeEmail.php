<?php

use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Control\Email\Email;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * A generic welcome email
 *
 * @link https://docs.silverstripe.org/en/5/developer_guides/email/
 * @author LeKoala <thomas@lekoala.be>
 */
class WelcomeEmail extends Email
{
    /**
     * @var string
     */
    protected $ss_template = "WelcomeEmail";

    /**
     * @param Member $member
     */
    public function __construct($member = null)
    {
        parent::__construct();

        $member = $member ? $member : Security::getCurrentUser();

        $link = Director::absoluteBaseUrl();
        $host = parse_url($link, PHP_URL_HOST);

        $this->setSubject(_t(
            'WelcomeEmail.SUBJECT',
            "Welcome to {Website}",
            'Email subject',
            ['Website' => SiteConfig::current_site_config()->Title]
        ));

        if ($member) {
            $to = $member->Email;
            if ($member->FirstName) {
                $name = trim($member->FirstName . ' ' . $member->Surname);
                $to = [$member->Email => $name];
            }
            $this->setTo($to);
        }

        $this->setData([
            'Member' => $member,
            'AbsoluteWebsiteLink' => $link,
            'WebsiteLink' => $host,
        ]);
    }
}
