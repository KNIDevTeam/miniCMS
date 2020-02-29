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
        echo require ABS_PATH.'/content/themes/'.$this->themeName.'/index.php';
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
        return $this->pageInfo;
    }

    private function getAsset($path)
    {
        return $this->baseUrl.$path;
    }
}