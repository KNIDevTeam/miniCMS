<?php

namespace Admin\Classes;

class Request
{
    private $url;
    private $method;
    private $userAgent;
    private $routePath;
    private $queryString;
    private $baseUrl;
    private $abortPaths;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->routePath = strtolower(substr($_SERVER['QUERY_STRING'], 2));
        $this->queryString = $this->parseGetVars();
        $this->baseUrl = $this->getBaseUrl();

        if (!defined('BASE_URL'))
            define('BASE_URL', $this->baseUrl);
    }

    /**
     * Magic method __get().
     *
     * @param $propertyName
     *
     * @return property|null
     */
    public function __get($propertyName)
    {
        if (isset($this->$propertyName))
            return $this->$propertyName;
        else
            return null;
    }

    /**
     * Redirect to specific path.
     *
     * @param $path
     */
    public function redirect($path)
    {
        die(header('Location: '.BASE_URL.$path));
    }

    /**
     * Abort.
     *
     * @param $codeNum
     */
    public function abort($codeNum)
    {
        return isset($this->abortPaths[$codeNum]) ? $this->redirect($this->abortPaths[$codeNum]) : $this->redirect('error/404');
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
     * Get base url of admin panel.
     *
     * @return string
     */
    private function getBaseUrl()
    {
        $path = '';
        $i = 1;
        $paths = explode('/', $_SERVER['SCRIPT_NAME']);

        foreach ($paths as $single)
            if ($i++ != count($paths))
                $path .= $single.'/';

        return 'http://'.$_SERVER['HTTP_HOST'].$path;
    }
}