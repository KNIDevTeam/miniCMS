<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\Editor;

class PagesController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('editPage', 'editPage', 'get', 'editPage');

        //Add menu
        $router->addMenu('Edytuj stronę', 'editPage', 'fa-pen', -1);
    }

    public function editPage()
    {
        $pageEditor = new Editor();
        $pageEditor->setName('Test');
        $pageEditor->setPath(ABS_PATH . '/admin/assets/editor/default-content.json');
        $pageEditor->setType('default');

        $this->view->set(['pageEditor' => $pageEditor]);
        $this->view->render('pages.edit');
    }
}