<?php
namespace Settings\Service;


interface SettingsInterface
{
    /**
     * Grab the settings
     * 
     * @param int $setting
     */
    public function getSetting($setting);
}