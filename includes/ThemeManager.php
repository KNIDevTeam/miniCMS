<?php

namespace MiniCMS\Includes;

class ThemeManager
{
    private $themeName;
    private $themeUrl;
    private $blocks;

    /**
     * ThemeManager constructor.
     */
    public function __construct()
    {
        $this->themeName = defined('THEME') ? THEME : 'default';
        $this->setThemeUrl();
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
        include_once(ABS_PATH.'/content/themes/'.$this->themeName.'/index.php');
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
        return $this->blocks[$blockName];
    }

    /**
     * Get asset url.
     *
     * @param $path
     *
     * @return string
     */
    private function getAsset($path)
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

}