<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\CRUD\PageFactory;
use Admin\Classes\CRUD\TemplateFactory;
use Admin\Classes\Editor;
use Admin\Classes\CRUD\Page;
use Admin\Classes\CRUD\PagesRepo;
use Admin\Classes\CRUD\TemplateRepo;


class PagesController extends ControllerAbstract
{
    private $pagesRepo;
    private $templatesRepo;

    public function __construct($request, $router)
    {
        $pagesPath = ABS_PATH . "/content/pages";
        $templatesPath = ABS_PATH . "/admin/assets/editor/templates";

        parent::__construct($request, $router);
        $this->pagesRepo = new PagesRepo($pagesPath, new PageFactory());
        $this->templatesRepo = new TemplateRepo($templatesPath, new TemplateFactory());
    }

    public static function setUp($router)
    {
        $router->addRoute('addPage', 'page/add', 'get', 'addPage');
        $router->addRoute('adding', 'page/adding', 'get', 'adding');
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
        $pageName = $this->getParams['name'];
        $pagePath = $this->pagesRepo->getPagePath($pageName);
        $pageEditor->setName($pageName);
        $pageEditor->setPath($pagePath.'/content.json');
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

    public function showPages()
    {
        $this->view->set(['pages' => $this->pagesRepo->getPagesNamesList()]);
        $this->view->render('pages.show');
    }

    public function addPage()
    {
        $error = '';
        if ($this->getParams['error']) $error = $this->getParams['error'];
        $this->view->set(['err' => $error]);
        $this->view->render('pages.addNew');
    }

    public function adding()
    {
        if ($this->pagesRepo->createPage($this->getParams['name'], $this->getParams['parent'], $this->getParams['template'], $this->templatesRepo))
            redirect($this->router->getRoute('editPage') . "?name=" . $this->getParams['name']);
        else
            redirect($this->router->getRoute('addPage') . "?error=no cos sie syplo"); #some error for now because i don't have any validation in adding logic
    }

    public function deletePage()
    {
        $this->pagesRepo->deletePage($this->getParams['name']);
        redirect($this->router->getRoute('showPages'));
    }

}
