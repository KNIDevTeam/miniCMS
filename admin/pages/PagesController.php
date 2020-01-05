<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\Editor;
use Admin\Classes\Page;
use Admin\Classes\PagesRepo;
use Admin\Classes\TemplateRepo;


class PagesController extends ControllerAbstract
{
    private $pagesRepo;
    private $templatesRepo;

    public function __construct($request, $router)
    {
        $pagesPath = ABS_PATH."/content/pages";
        $templatesPath = ABS_PATH."/admin/assets/editor/templates";

        parent::__construct($request, $router);
        $this->pagesRepo = new PagesRepo($pagesPath);
        $this->templatesRepo = new TemplateRepo($templatesPath);
    }

    public static function setUp($router)
    {
        $router->addRoute('addPage', 'page/add', 'get', 'addPage');
        $router->addRoute('editPage', 'page/edit', 'get', 'editPage');
        $router->addRoute('savePage', 'page/save', 'post', 'savePage', true);
        $router->addRoute('showPages', 'page/show', 'get', 'showPages');
        $router->addRoute('deletePage', 'page/delete', 'get', 'deletePage');
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
        $this->view->set(['pages' => $this->pagesRepo->getPagesNamesList()]);
        $this->view->render('pages.show');
    }

    public function addPage()
    {
        #empty for now
    }

    public function adding()
    {
        #empty for now

    }

    public function deletePage()
    {
        #empty for now
    }




}