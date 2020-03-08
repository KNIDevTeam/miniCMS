<?php

namespace Content\Classes;

class ThemeManager
{
    private $themeName = 'mainTheme';
    private $menu;
    private $pageInfo;
    private $siteTitle = 'No elo';
    private $baseUrl;

    public function __construct($pageInfo, $menu)
    {
        $this->pageInfo = $pageInfo;
        $this->menu = $menu;
        $this->baseUrl = BASE_URL.'content/themes/'.$this->themeName.'/';
    }

    public function render()
    {
        ob_start();
        include_once(ABS_PATH.'/content/themes/'.$this->themeName.'/index.php');
        echo ob_get_clean();
    }

    private function getTitle()
    {
        return $this->siteTitle;
    }

    private function getMenu()
    {
        return $this->menu;
    }

    private function getContent()
    {
        return $this->pageInfo['content'];
    }

    private function getAsset($path)
    {
        return $this->baseUrl.$path;
    }
}