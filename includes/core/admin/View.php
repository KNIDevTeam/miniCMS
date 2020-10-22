<?php

namespace MiniCMS\Includes\Core\Admin;

use MiniCMS\Includes\Core\Security;
use MiniCMS\Includes\Core\ThemeManager;

class View
{
    private const VIEWS_PATH = ABS_PATH.'/admin/views/';

    private $sections;
    private $currentSection;

    private $request;
    private $router;
    private $security;
    private $lang;
    private $params = [];

    /**
     * View constructor.
     *
     * @param $request
     * @param $router
     * @param $lang
     */
    public function __construct($request, $router, $lang)
    {
        $this->request = $request;
        $this->router = $router;
        $this->security = Security::getInstance();
        $this->lang = $lang;

        if (isset($_SESSION['_redirect_data'])) {
            $this->set($_SESSION['_redirect_data']);
            unset($_SESSION['_redirect_data']);
        }
    }

    /**
     * Get url to asset.
     *
     * @param $path
     *
     * @return string
     */
    public function asset($path)
    {
        return BASE_ADMIN_URL.$path;
    }

    /**
     * Get translation.
     *
     * @param $key
     * @param string $zone
     *
     * @return mixed
     */
    private function _($key, $zone = 'core')
    {
        return $this->lang->_($key, $zone);
    }

    /**
     * Render specific view.
     *
     * @param $fileName
     *
     * @return false|string
     *
     * @throws \Exception
     */
    public function render($fileName)
    {
        $this->addBaseSections();

        if (!empty($this->params))
            extract($this->params);

        if ($this->fileExists($fileName)) {
            $fileName = $this->getFilePath($fileName);
            ob_start();

            include_once($fileName);

            $content = ob_get_clean();

            $themeManager = new ThemeManager();
            $themeManager->setLang($this->lang);
            $themeManager->addBlock('title', $this->getSection('title'));
            $themeManager->addBlock('headerScripts', $this->getSection('headerScripts'));
            $themeManager->addBlock('menu', $this->getMenu());
            $themeManager->addBlock('content', $content);
            return $themeManager->render();
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
        $this->params = array_merge($this->params, $array);
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
     * Add base sections from admin/views/baseSections.php.
     *
     * @throws \Exception
     */
    private function addBaseSections()
    {
        if ($this->fileExists('baseSections')) {
            require_once($this->getFilePath('baseSections'));
        }
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
        return self::VIEWS_PATH.$fileName.'.php';
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