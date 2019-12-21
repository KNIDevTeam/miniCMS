<?php

namespace Admin\Classes;

class View
{
    private $viewsPath;
    private $baseUrl;
    private $request;
    private $router;
    private $security;

    /**
     * View constructor.
     *
     * @param $request
     * @param $security
     */
    public function __construct($request, $security)
    {
        $this->viewsPath = ABS_PATH.'/admin/pages/views/';
        $this->request = $request;
        $this->security = $security;
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
     * Get specific view.
     *
     * @param $fileName
     */
    public function get($fileName)
    {
        if (!empty($this->params))
            extract($this->params);

        $fileName = str_replace('.', '/', $fileName);

        if (file_exists($this->viewsPath.$fileName.'.php')) {
            $this->header();
            include_once($this->viewsPath.$fileName.'.php');
            $this->footer();
        } else
            echo 'Podany view nie istnieje';
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
        return $this->request->baseUrl.$path;
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