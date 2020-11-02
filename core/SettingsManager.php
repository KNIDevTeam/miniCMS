<?php

namespace Core;

class SettingsManager
{
    /**
     * /config.json file path.
     *
     * @const
     */
    private const CONFIG_PATH = ABS_PATH.'config.json';

    /**
     * All possible settings.
     * key => default_value
     *
     * @const
     */
    private const ALL_SETTINGS = [
        'DEBUG' => false,
        'SITE_NAME' => '',
        'THEME' => 'default',
        'MULTI_LANG' => false,
        'DEFAULT_LANG' => 'pl'
    ];

    /**
     * Array with settings properties from /config.json file.
     *
     * @var
     */
    private $settingsArray;

    /**
     * SettingsManager constructor.
     * On construct loadSettings and checkSettings.
     */
    public function __construct()
    {
        $this->loadSettings();
        $this->checkSettings();
    }

    /**
     * Settings getter.
     *
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settingsArray;
    }

    /**
     * Load settings from /config.json file.
     */
    private function loadSettings()
    {
        $this->settingsArray = json_decode(file_get_contents(self::CONFIG_PATH), true);
    }

    /**
     * Save settings from param to /config.json file.
     *
     * @param $settings
     */
    private function saveSettings($settings)
    {
        file_put_contents(self::CONFIG_PATH, json_encode($settings));
    }

    /**
     * Check if all possible settings are in the /config.json file.
     * If not, merge them and save to the file.
     */
    private function checkSettings()
    {
        $shouldSave = false;

        foreach (self::ALL_SETTINGS as $key => $defaultValue)
            if (!isset($this->settingsArray[$key])) {
                $this->settingsArray[$key] = $defaultValue;
                $shouldSave = true;
            }

        if ($shouldSave) $this->saveSettings($this->settingsArray);
    }
}