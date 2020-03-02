<?php

namespace Admin\Classes;

class View
{
    private $viewsPath;
    private $security;
    private $router;
    private $sections;
    private $layout;
    private $currentSection;

    /**
     * View constructor.
     *
     * @param $router
     */
    public function __construct($router)
    {
        $this->viewsPath = ABS_PATH.'/admin/pages/views/';
        $this->security = new Security();
        $this->router = $router;
    }

    /**
     * Set route object as property.
     *
     * @param $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * Render specific view.
     *
     * @param $fileName
     *
     * @throws \Exception
     */
    public function render($fileName)
    {
        if (!empty($this->params))
            extract($this->params);

        if ($this->fileExists($fileName)) {
            $fileName = $this->getFilePath($fileName);
            ob_start();

            include_once($fileName);

            $output = ob_get_clean();

            if (isset($this->layout)) {
                $this->includeLayout();
                echo $this->layout;
            } else
                echo $output;
        }
    }

    /**
     * Add section with inline content.
     *
     * @param $sectionName
     * @param $content
     */
    public function section($sectionName, $content)
    {
        $this->sections[$sectionName] = $content;
    }

    /**
     * Start new section.
     *
     * @param $sectionName
     */
    public function startSection($sectionName)
    {
        $this->currentSection = $sectionName;
        ob_start();
    }

    /**
     * End current section.
     *
     * @throws \Exception
     */
    public function endSection()
    {
        if (isset($this->currentSection)) {
            $this->sections[$this->currentSection] = ob_get_contents();
            unset($this->currentSection);
        } else
            throw new \Exception("Section wasn't opened");
    }
    
    /**
     * Set vars to params.
     *
     * @param $array
     */
    public function set($array)
    {
        $this->params = $array;
    }

    /**
     * Extend layout.
     *
     * @param $layout
     *
     * @throws \Exception
     */
    public function extend($layout)
    {
        if ($this->fileExists($layout))
            $this->layout = $layout;
    }

    /**
     * Include layout.
     *
     * @throws \Exception
     */
    public function includeLayout()
    {
        if ($this->fileExists($this->layout)) {
            ob_start();
            include_once($this->getFilePath($this->layout));
            $this->layout = ob_get_clean();
        }
    }

    /**
     * Get section by its name.
     *
     * @param $sectionName
     *
     * @return string
     */
    public function getSection($sectionName)
    {
        return (isset($this->sections[$sectionName]) ? $this->sections[$sectionName] : '');
    }

    /**
     * Get menu in html.
     *
     * @return string
     */
    private function getMenu()
    {
        $menu = '<ul>';

        foreach ($this->router->getMenu() as $name => $single) {
            // Single item
            if ($single['routeName'] != '') {
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

        return $menu;
    }

    /**
     * Get path of file.
     *
     * @param $fileName
     *
     * @return string
     */
    private function getFilePath($fileName)
    {
        $fileName = str_replace('.', '/', $fileName);
        return $this->viewsPath.$fileName.'.php';
    }

    /**
     * Check if file exists.
     *
     * @param $fileName
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function fileExists($fileName)
    {
        if (!file_exists($this->getFilePath($fileName)))
            throw new \Exception("View | File: ".$fileName." does not exists.");

        return true;
    }
}