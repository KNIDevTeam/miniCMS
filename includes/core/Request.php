<?php

namespace MiniCMS\Includes\Core;

class Request
{
    private $url;
    private $method;
    private $userAgent;
    private $path;
    private $queryString;
    private $isAjax;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->path = $this->getPath();
        $this->queryString = $this->parseGetVars();
        $this->isAjax = $this->isAjax();
    }

    /**
     * Magic __get method.
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
}