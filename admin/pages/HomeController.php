<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;

class HomeController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('home', '', 'get', 'home');
        $router->addMenu('Strona główna', 'home', 'fa-home', -1);
    }

    public function home()
    {
        $this->view->set(['maslo' => ['cos' => 'xd']]);
        $this->view->render('home');
    }
}