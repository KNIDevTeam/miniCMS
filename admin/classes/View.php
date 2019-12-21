<?php

namespace Admin\Classes;

class View
{
    private $viewsPath;
    private $security;
    private $router;

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

        $fileName = str_replace('.', '/', $fileName);

        if (file_exists($this->viewsPath.$fileName.'.php')) {
            $this->header();
            include_once($this->viewsPath.$fileName.'.php');
            $this->footer();
        } else
            throw new \Exception("View: ".$fileName." does not exists.");
    }

    /**
     * Make url to asset.
     *
     * @param $path
     *
     * @return string
     */
    public function asset($path)
    {
        return BASE_URL.$path;
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

    public function crsf()
    {
        echo '<input type="hidden" name="crsf_token" value="'.$this->security->getCRSF().'"/>';
    }
    
    /**
     * Include header.
     */
    private function header()
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

        include_once($this->viewsPath.'header.php');
    }

    /**
     * Include footer.
     */
    private function footer()
    {
        include_once($this->viewsPath.'footer.php');
    }
}