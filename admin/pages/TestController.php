<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;

class TestController extends ControllerAbstract
{
    public static function setRoutes($router)
    {
        $router->addRoute('test', 'test', 'get', 'index');
        $router->addRoute('testPost', 'test/post', 'post', 'post');
    }

    public function index()
    {
        $this->view->get('test.index');
    }

    public function post()
    {
        $input = $_POST['cebula'];

        $this->view->set(['var' => $input]);
        $this->view->get('test.result');
    }
}