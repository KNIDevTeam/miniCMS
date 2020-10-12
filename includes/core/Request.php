<?php

namespace MiniCMS\Includes\Core;

class Request
{
    private $url;
    private $baseUrl;
    private $baseAdminUrl;
    private $method;
    private $userAgent;
    private $path;
    private $queryString;
    private $isAjax;

    /* Singleton needed start */
    protected static $_instance;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->setUp();
        }

        return self::$_instance;
    }
    /* Singleton needed end */

    /**
     * Set up.
     */
    private function setUp()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->setBaseUrl();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->path = $this->getPath();
        $this->queryString = $this->parseGetVars();
        $this->isAjax = $this->isAjax();
    }

    /**
     * Magic __get method/
     *
     * @param $propertyName
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($propertyName)
    {
        if (isset($this->$propertyName))
            return $this->$propertyName;
        else
            throw new \Exception("Property: ".$propertyName." does not exist.");
    }

    /**
     * Redirect to specific path.
     *
     * @param $to
     * @param string $type
     */
    public function redirect($to, $type = TYPE)
    {
        die(header('Location: '.((strtolower($type) == 'admin' ? $this->baseAdminUrl : $this->baseUrl).$to)));
    }

    /**
     * Abort.
     *
     * @param $code
     */
    public function abort($code)
    {
        $this->redirect('error/'.$code);
    }

    /**
     * Parse get vars from url.
     *
     * @return array
     */
    private function parseGetVars()
    {
        $queryString = parse_url($this->url, PHP_URL_QUERY);
        $toReturn = [];

        if ($queryString != '') {
            foreach (explode('&', $queryString) as $param) {
                $param = explode('=', $param);
                if (count($param) > 1)
                    $toReturn[$param[0]] = $param[1];
                else
                    $toReturn[$param[0]] = null;
            }
        }

        return $toReturn;
    }

    /**
     * Check if request is via AJAX.
     *
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Get request path.
     *
     * @return string
     */
    private function getPath()
    {
        return strtolower(substr($_SERVER['QUERY_STRING'], 2));
    }

    /**
     * Get base url of admin panel.
     *
     * @return string
     */
    private function setBaseUrl()
    {
        $path = '';
        $i = 1;
        $paths = explode('/', $_SERVER['SCRIPT_NAME']);

        foreach ($paths as $single)
            if ($i++ != count($paths))
                $path .= $single.'/';

        $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http' ).'://'.$_SERVER['HTTP_HOST'].$path;

        if (TYPE == 'ADMIN') {
            $this->baseAdminUrl = $url;
            $this->baseUrl = str_replace('admin/', '', $url);
        } else {
            $this->baseUrl = $url;
            $this->baseAdminUrl = $url."admin/";
        }
    }
}