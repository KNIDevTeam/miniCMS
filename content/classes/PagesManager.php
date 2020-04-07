<?php

namespace Content\Classes;

class PagesManager
{
    private $currentPageName;
    private $currentPage;
    private $pages = [];
    private $pageExists = false;
    private $menu;

    /**
     * PagesManager constructor.
     *
     * @param $currentPageName
     */
    public function __construct($currentPageName)
    {
        $this->currentPageName = strtolower($currentPageName);
        $this->pages = $this->scanPages(ABS_PATH.'/content/pages');
        $this->menu = $this->generateMenu($this->pages);
    }

    /**
     * Get pageExists property.
     *
     * @return bool
     */
    public function pageExists()
    {
        return $this->pageExists;
    }

    /**
     * Scan for pages. (Recursive)
     *
     * @param $path
     *
     * @return array|null
     */
    private function scanPages($path)
    {
        $isDir = false;
        $pages = [];
        $files = scandir($path);
        $path .= '/';

        foreach (array_slice($files, 2) as $file) {
            if (is_dir($path.$file) && $this->areNecessaryFiles($path.$file, $file)) {
                if (strtolower($file) == $this->currentPageName) {
                    $this->pageExists = true;
                    $this->currentPage['content'] = $this->getFile($path.$file, $file.'.json.cmp');
                }

                $pages[$file]['info'] = $this->getJson($path.$file, $file.'.info.json');
                $pages[$file]['children'] = $this->scanPages($path.$file);
                if ($pages[$file]['children'] == null) unset($pages[$file]['children']);
                $isDir = true;
            }
        }

        if (!$isDir)
            return null;
        else
            return $pages;
    }

    /**
     * Generate menu.
     *
     * @param $pages
     *
     * @return string
     */
    private function generateMenu($pages)
    {
        $menu = '<ul class="main-menu">';

        foreach ($pages as $pageName => $page) {
            $menu .= '<li class="item top-item"><a href="'.BASE_URL.$pageName.'" class="menu-link top-menu-link">'.str_replace('_', ' ', $pageName).'</a>';
            if (isset($page['children']))
                $menu .= $this->generateSubMenu($page['children']);
            $menu .= '</li>';
        }

        $menu .= '</ul>';
        return $menu;
    }

    /**
     * Generate sub menu.
     *
     * @param $pages
     *
     * @return string
     */
    private function generateSubMenu($pages)
    {
        $menu = '<ul class="sub-menu">';

        foreach ($pages as $pageName => $page) {
            $menu .= '<li class="item"><a href="'.BASE_URL.$pageName.'" class="menu-link">'.str_replace('_', ' ', $pageName).'</a>';
            if (isset($page['children']))
                $menu .= $this->generateSubMenu($page['children']);
            $menu .= '</li>';
        }

        $menu .= '</ul>';
        return $menu;
    }

    /**
     * Check if necessary files exist.
     *
     * @param $path
     * @param $name
     *
     * @return bool
     */
    private function areNecessaryFiles($path, $name)
    {
        return file_exists($path.'/'.$name.'.json') &&
            file_exists($path.'/'.$name.'.info.json') &&
            file_exists($path.'/'.$name.'.json.cmp');
    }

    /**
     * Get array from json file.
     *
     * @param $path
     * @param $name
     *
     * @return mixed
     */
    private function getJson($path, $name)
    {
        return json_decode(file_get_contents($path.'/'.$name), true);
    }

    /**
     * Get file contents.
     *
     * @param $path
     * @param $name
     *
     * @return mixed
     */
    private function getFile($path, $name)
    {
        return file_get_contents($path.'/'.$name);
    }

    /**
     * Get all pages.
     *
     * @return array
     */
    public function getAllPages()
    {
        return $this->pages;
    }

    /**
     * Get current page.
     *
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Get menu.
     *
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }
}