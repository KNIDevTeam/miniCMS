<?php

namespace MiniCMS\Includes\Core;

class BaseClass
{
    protected $request;
    protected $security;

    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->security = Security::getInstance();
    }

    protected function request()
    {
        return $this->request;
    }

    protected function security()
    {
        return $this->security;
    }
}