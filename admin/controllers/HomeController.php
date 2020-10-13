<?php

namespace MiniCMS\Admin\Controllers;

use MiniCMS\Includes\Core\Admin\ControllerAbstract;
use MiniCMS\includes\core\Response;

class HomeController extends ControllerAbstract
{
    public static function setUp($router, $lang)
    {
        $router->addRoute('home', '', 'get', 'home');
        $router->addMenu($lang->_('home.title'), 'home', 'fa-home', -1);
    }

    public function home()
    {
        $this->view->set(['maslo' => ['cos' => 'xd']]);
        return new Response($this->view->render('home'));
    }
}