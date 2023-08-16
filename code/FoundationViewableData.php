<?php

use SilverStripe\View\ViewableData;
use SilverStripe\Control\Email\Email;

class FoundationViewableData extends ViewableData
{
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Keep scope without having to pass variables to includes
     *
     * Use configured theme if any
     *
     * @param string $template
     * @return string
     */
    public function foundationTemplate($template)
    {
        $theme = FoundationEmails::config()->theme;
        $templates = ['Includes/' . $template];
        if ($theme && $theme != 'none') {
            array_unshift($templates, 'Includes/' . $template . '_' . $theme);
        }
        return $this->renderWith($templates, $this->email->getData());
    }
}
