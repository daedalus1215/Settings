<?php
namespace Settings\Service;


interface SettingsServiceInterface
{
    /**
     * Grab the settings
     *
     * @param int $setting
     */
    public function getSetting($setting);
}