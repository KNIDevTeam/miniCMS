<?php

namespace Admin\Classes;

class Request
{
    private $url;
    private $method;
    private $userAgent;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
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
}