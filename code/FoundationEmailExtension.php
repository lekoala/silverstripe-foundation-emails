<?php

use SilverStripe\Core\Extension;

class FoundationEmailExtension extends Extension
{
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
        return $this->owner->renderWith($templates, $this->owner->getData());
    }
}
