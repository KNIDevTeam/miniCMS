<?php

namespace Admin\Classes;

use http\Exception;

class View
{
    private $viewsPath;
    private $router;
    private $security;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->viewsPath = ABS_PATH.'/admin/pages/views/';
        $this->security = new Security();
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