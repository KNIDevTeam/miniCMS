<?php

namespace Core;

class Lang
{
    private const APP_LANG_PATH = ABS_PATH.'app/Lang/';
    private const THEME_LANG_PATH = ABS_PATH.'content/themes/'.THEME.'/lang/';

    private $currentLang;
    private $translations;

    /**
     * Lang constructor.
     *
     * @param $lang
     */
    public function __construct($lang)
    {
        $this->currentLang = $lang;
        $this->translations['core'] = $this->getCoreTranslations();
        $this->translations['theme'] = $this->getThemeTranslations();
    }

    /**
     * Translate specified $key.
     *
     * @param $key
     * @param string $zone
     *
     * @return mixed
     */
    public function _($key, $zone = 'core')
    {
        if (isset($this->translations[$zone])) {
            $keyParts = explode('.', $key);

            if (isset($this->translations[$zone][$keyParts[0]])) {
                $translated = $this->translations[$zone][$keyParts[0]];

                foreach (array_slice($keyParts, 1) as $part) {
                    if (isset($translated[$part]))
                        $translated = $translated[$part];
                    else
                        return $key;
                }

                return $translated;
            }
        }

        return $key;
    }

    /**
     * Get current language code;
     *
     * @return mixed
     */
    public function getCurrentLang()
    {
        return $this->currentLang;
    }

    /**
     * Get core translations from /app/Lang/.
     *
     * @return mixed
     */
    private function getCoreTranslations()
    {
        return require_once self::APP_LANG_PATH.$this->currentLang.'.php';
    }

    /**
     * Get theme translations from /content/themes/CURRENT_THEME/lang.
     *
     * @return mixed
     */
    private function getThemeTranslations()
    {
        return require_once self::THEME_LANG_PATH.$this->currentLang.'.php';
    }
}