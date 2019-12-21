<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;

class TestController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('test', 'test', 'get', 'index');
        $router->addRoute('test2', 'test/sub', 'get', 'submenu');
        $router->addRoute('testPost', 'test/post', 'post', 'post');

        //Add menu
        $router->addMenu('Test', '', 'fa-pen', -1); // Parent with no routeName
        $router->addMenu('Test submenu1', 'test', 'fa-home', 'Test');
        $router->addMenu('Test Submenu2', 'test2', 'fa-pen', 'Test');
    }

    public function index()
    {
        $this->view->render('test.index');
    }

    public function submenu()
    {
        $this->view->render('test.index');
    }

    public function post()
    {
        $input = $this->postParams['cebula'];

        $this->view->set(['var' => $input]);
        $this->view->render('test.result');
    }
}