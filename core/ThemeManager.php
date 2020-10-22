<?php

namespace Core;

class ThemeManager
{
    private const THEMES_PATH = ABS_PATH.'/content/themes/';

    private $themeName;
    private $themeUrl;
    private $blocks;
    private $isAdmin;
    private $isUser;
    private $lang;

    /**
     * ThemeManager constructor.
     */
    public function __construct()
    {
        $this->themeName = defined('THEME') ? THEME : 'default';
        $this->setThemeUrl();
        $this->isAdmin = TYPE == 'ADMIN';
        $this->isUser = !$this->isAdmin;
    }

    /**
     * Set lang object.
     *
     * @param $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Add block to theme manager.
     *
     * @param $blockName
     * @param $data
     */
    public function addBlock($blockName, $data)
    {
        $this->blocks[$blockName] = $data;
    }

    /**
     * Render view from theme.
     *
     * @return false|string
     */
    public function render()
    {
        ob_start();
        require_once(self::THEMES_PATH.$this->themeName.'/'.(TYPE == 'ADMIN' ? 'admin' : 'user').'.php');
        return ob_get_clean();
    }

    /**
     *  Render Error page from theme.
     *
     * @param $code
     *
     * @return false|string
     */
    public function renderError($code)
    {
        $this->addBlock('title', $this->lang->_('errors.'.$code.'.title'));
        $this->addBlock('content', $this->lang->_('errors.'.$code.'.desc'));
        ob_start();
        require_once(ABS_PATH.'/content/themes/'.$this->themeName.'/error.php');
        return ob_get_clean();
    }

    /**
     * Get translation default from theme zone.
     *
     * @param $key
     * @param string $zone
     *
     * @return mixed
     */
    private function _($key, $zone = 'theme')
    {
        return $this->lang->_($key, $zone);
    }

    /**
     * Get block.
     *
     * @param $blockName
     *
     * @return mixed
     */
    private function getBlock($blockName)
    {
        return (isset($this->blocks[$blockName]) ? $this->blocks[$blockName] : '');
    }

    /**
     * Get asset url.
     *
     * @param $path
     *
     * @return string
     */
    private function asset($path)
    {
        return $this->themeUrl.$path;
    }

    /**
     * Set theme url.
     */
    private function setThemeUrl()
    {
        $this->themeUrl = BASE_URL.'content/themes/'.$this->themeName.'/';
    }

    /**
     * Generate language switcher form.
     */
    private function langSwitcher()
    {
        if (MULTI_LANG) {
            echo "<form method='post' action='".BASE_URL."_language_switcher'>";
            echo "<select name='lang' onchange='this.form.submit()'>";
            echo "<option value='pl' ".($this->lang->getCurrentLang() == 'pl' ? 'selected' : '').">PL</option>";
            echo "<option value='en' ".($this->lang->getCurrentLang() == 'en' ? 'selected' : '').">EN</option>";
            echo "</select>";
            echo "</form>";
        }
    }
}
