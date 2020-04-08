<?php

namespace Admin\Classes\Core;

class ErrorsController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('error404', 'error/404', 'get', 'error404');
        $router->addRoute('error500', 'error/500', 'get', 'error500');
    }

    public function error404()
    {
        $this->view->render('errors.404');
    }

    public function error500()
    {
        $this->view->render('errors.500');
    }
}