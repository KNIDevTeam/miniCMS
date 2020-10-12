<?php

namespace MiniCMS\Content\Classes;

class ThemeManager
{
    private $themeName = 'mainTheme';
    private $menu;
    private $pageInfo;
    private $siteTitle;
    private $baseUrl;

    /**
     * ThemeManager constructor.
     *
     * @param $pageInfo
     * @param $menu
     */
    public function __construct($pageInfo, $menu)
    {
        $this->pageInfo = $pageInfo;
        $this->menu = $menu;
        $this->baseUrl = BASE_URL.'content/themes/'.$this->themeName.'/';
        $this->siteTitle = $pageInfo['title'];
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
     * Get site title.
     *
     * @return mixed
     */
    private function getTitle()
    {
        return $this->siteTitle;
    }

    /**
     * Get menu.
     *
     * @return mixed
     */
    private function getMenu()
    {
        return $this->menu;
    }

    /**
     * Get page content.
     *
     * @return mixed
     */
    private function getContent()
    {
        return $this->pageInfo['content'];
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
        return $this->baseUrl.$path;
    }
}