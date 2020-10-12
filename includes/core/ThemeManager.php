<?php

namespace MiniCMS\Includes\Core;

class ThemeManager
{
    private $themeName;
    private $themeUrl;
    private $blocks;
    private $isAdmin;
    private $isUser;

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
     * Render view.
     */
    public function render()
    {
        ob_start();
        include_once(ABS_PATH.'/content/themes/'.$this->themeName.'/'.(TYPE == 'ADMIN' ? 'admin' : 'user').'.php');
        echo ob_get_clean();
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
        $this->themeUrl = Request::getInstance()->baseUrl.'content/themes/'.$this->themeName.'/';
    }

}