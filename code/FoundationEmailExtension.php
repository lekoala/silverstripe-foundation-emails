<?php

use SilverStripe\Core\Extension;
use SilverStripe\View\ArrayData;
use SilverStripe\View\ViewableData;

class FoundationEmailExtension extends Extension
{
    public function updateGetData(ViewableData $data)
    {
        // Since methods are not callable anymore, pass them to data
        $data->foundationColors = $this->foundationColors();
        // Since we cannot set methods, add a custom failover
        $data->setFailover(new FoundationViewableData($this->owner));
    }

    /**
     * @return ArrayData
     */
    public function foundationColors()
    {
        $colors = FoundationEmails::config()->colors;
        $this->owner->extend('updateFoundationColors', $colors);
        return new ArrayData($colors);
    }

    public function foundationRender()
    {
        $reflectionMethod = new ReflectionMethod($this->owner, 'updateHtmlAndTextWithRenderedTemplates');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($this->owner);
    }
}
