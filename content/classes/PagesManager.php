<?php

namespace Content\Classes;

class PagesManager
{
    private $currentPage;
    private $pages = [];
    private $pageExists = false;

    /**
     * PagesManager constructor.
     *
     * @param $currentPage
     */
    public function __construct($currentPage)
    {
        $this->currentPage = ucfirst($currentPage);
        $this->pages = $this->scanPages(ABS_PATH.'/content/pages');
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
                if ($file == $this->currentPage) $this->pageExists = true;

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
     * Get all pages.
     *
     * @return array
     */
    public function getAllPages()
    {
        return $this->pages;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getAllPagesHtml()
    {
        /*$menu = '<ul>';

        foreach ($this->pages as $name => $single) {
            $menu .= '<li><a href="#">'.$name.'</a>';



            // Single item
            if (!) {
                $menu .= '<li'.$this->router->getActive($single['routeName']).'><a href="'.$single['href'].'">';
                if ($single['icon'] != '')
                    $menu .= '<i class="fas '.$single['icon'].'"></i>';
                $menu .= $name.'</a></li>';

            } else { // Submenu
                $isActive = false;
                $submenu = '';

                foreach ($single['children'] as $subName => $subSingle) {
                    if ($this->router->getActive($subSingle['routeName']) != '') $isActive = true;
                    $submenu .= '<li class="submenu '.trim($name).'"><a href="'.$subSingle['href'].'">';
                    if ($subSingle['icon'] != '')
                        $submenu .= '<i class="fas '.$subSingle['icon'].'"></i>';
                    $submenu .= $subName.'</a></li>';
                }

                $menu .= '<li class="'.($isActive ? 'active ' : '').'expand" id="'.trim($name).'">';
                if ($single['icon'] != '')
                    $menu .= '<i class="fas '.$single['icon'].'"></i>';
                $menu .= $name.'</li>'.$submenu;
            }
        }

        $menu .= '</ul>';

        return $menu;*/
    }
}