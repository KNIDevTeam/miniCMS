<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;

class ErrorsController extends ControllerAbstract
{
    public static function setRoutes($router)
    {
        $router->addRoute('error404', 'error/404', 'get', 'error404');
    }

    public function error404()
    {
        $this->view->get('errors.404');
    }
}