<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\Editor;
use Admin\Classes\Pages;


class PagesController extends ControllerAbstract
{
    public static function setUp($router)
    {
        $router->addRoute('addPage', 'addPage', 'get', 'addPage');
        $router->addRoute('editPage', 'page/edit', 'get', 'editPage');
        $router->addRoute('savePage', 'page/save', 'post', 'savePage', true);
        $router->addRoute('previewPage', 'page/preview', 'post', 'previewPage', true);

        //Add menu
        $router->addMenu('Edytuj stronę', 'editPage', 'fa-pen', -1);
    }

    public function addPage()
    {
        $pageName = $this->getParams['pageName'];
        $pageParent = $this->getParams['pageParent'];
        $pageTemplate = $this->getParams['pageTemplate'];
        $newPage = new Pages();

        $newPage->createPage($pageName, $pageParent, $pageTemplate);
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
        $pageEditor->saveFile($pagePath, $pageContent, "Save");
        echo "Saved";
    }

    public function previewPage()
    {
        $pageEditor = new Editor();
        $pageContent = $this->postParams['json'];
        $pagePath = $this->postParams['path'];
        $pageEditor->saveFile($pagePath, $pageContent, "Preview");
        echo "Saved";
    }
}