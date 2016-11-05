<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Settings\\Service\\SettingsService' => 'Settings\\Factory\\SettingsServiceFactory',
        ),
    ),
);