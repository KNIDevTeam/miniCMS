<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\Editor;


class PagesController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('editPage', 'page/edit', 'get', 'editPage');
        $router->addRoute('savePage', 'page/save', 'post', 'savePage', true);
        $router->addRoute('showPages', 'page/show', 'get', 'showPages');
        $router->addRoute('addPage', 'page/add', 'get', 'addPage');
        //Add menu
        $router->addMenu('Strony', 'showPages', 'fa-pen', -1);
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

    public function savePage()
    {
        $pageEditor = new Editor();
        $pageContent = $this->postParams['json'];
        $pagePath = $this->postParams['path'];
        $pageEditor->saveFile($pagePath, $pageContent);
        echo "Saved";
        //zrob sobie cos
    }

    public function showPages()
    {
        $content_dir = str_replace("admin", "content/pages", getcwd());
        $list_of_pages = scandir($content_dir);

        $this->view->set(['pages' => $list_of_pages, 'err' => ""]);
        $this->view->render('pages.show');
    }

    public function addPage()
    {
        //$name = $_GET['name'];
        $name = "abba";
        $content_dir = str_replace("admin", "content/pages", getcwd());
        $list_of_pages = scandir($content_dir);
        if(in_array($name, $list_of_pages))
        {
            mkdir($content_dir.$name);
            $err = "";
        }
        else
        {
            $err = "Strona o tej nazwie już istnieje";
        }
        $list_of_pages = scandir($content_dir);

        $this->view->set(['pages' => $list_of_pages, 'err' => $err]);
        $this->view->render('pages.show');
    }
}