<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;

class HomeController extends ControllerAbstract
{
    public static function setRoutes($router)
    {
        $router->addRoute('home', '', 'get', 'home');
    }

    public function home()
    {
        $this->view->set(['maslo' => ['cos' => 'xd']]);
        $this->view->render('home');
    }
}