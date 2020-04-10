<?php

namespace Admin\Pages;

use Admin\Classes\Core\ControllerAbstract;
use Admin\Classes\crud\PageFactory;
use Admin\Classes\crud\TemplateFactory;
use Admin\Classes\Editor;
use Admin\Classes\crud\Page;
use Admin\Classes\crud\PagesRepo;
use Admin\Classes\crud\TemplateRepo;
use Admin\Classes\MediaManager;


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
        $router->addRoute('adding', 'page/adding', 'post', 'adding');
        $router->addRoute('editPage', 'page/edit', 'get', 'editPage');
        $router->addRoute('savePage', 'page/save', 'post', 'savePage', true);
        $router->addRoute('showPages', 'page/show', 'get', 'showPages');
        $router->addRoute('deletePage', 'page/delete', 'get', 'deletePage');
        $router->addRoute('saveFile', 'page/saveFile', 'post', 'saveFile', true, true);
        $router->addRoute('saveImageFile', 'page/saveImage/file', 'post', 'saveImageFile', true, true);
        $router->addRoute('saveImageUrl', 'page/saveImage/url', 'post', 'saveImageUrl', true, true);
        //Add menu
        $router->addMenu('Strony', 'showPages', 'fa-pen', -1);
    }

    public function editPage()
    {
        $pageEditor = new Editor();
        $pageName = $this->getParams['name'];
        $pagePath = $this->pagesRepo->getPagePath($pageName);
        $pageEditor->setName($pageName);
        $pageEditor->setPath($pagePath.'/'.$pageName.'.json');
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
        if (isset($this->getParams['error'])) $error = $this->getParams['error'];
        $this->view->set(['err' => $error, 'pages' => $this->pagesRepo->getPagesNamesList(), 'templates' => $this->templatesRepo->listTemplates()]);
        $this->view->render('pages.addNew');
    }

    public function adding()
    {

        if ($this->pagesRepo->createPage(urldecode(str_replace(" ", "_", $this->postParams['name'])), urldecode($this->postParams['parent']),
            urldecode($this->postParams['template']), $this->templatesRepo))
            redirect($this->router->getRoute('editPage') . "?name=" . urldecode(str_replace(" ", "_", $this->postParams['name'])));
        else
            redirect($this->router->getRoute('addPage') . "?error=no cos sie syplo"); #some error for now because i don't have any validation in adding logic
    }

    public function deletePage()
    {
        $this->pagesRepo->deletePage(urldecode($this->getParams['name']));
        redirect($this->router->getRoute('showPages'));
    }

    public function saveFile()
    {
        $response = ['success' => 0];

        if(isset($_FILES['file']['name'])) {
            $mediaManager  = new MediaManager($_FILES['file']);
            if ($mediaManager->moveFile()) {
                $response['success'] = 1;
                $response['file'] = [
                    'name' => $mediaManager->getFileFullName(),
                    'url' => $mediaManager->getFileUrl(),
                    'ext' => $mediaManager->getFileExtension()
                ];
            }
        }

        echo json_encode($response);
    }

    public function saveImageFile()
    {
        $response = ['success' => 0];

        if(isset($_FILES['image']['name'])) {
            $mediaManager  = new MediaManager($_FILES['image']);
            if ($mediaManager->moveFile()) {
                $response['success'] = 1;
                $response['file'] = [
                    'name' => $mediaManager->getFileFullName(),
                    'url' => $mediaManager->getFileUrl(),
                    'ext' => $mediaManager->getFileExtension()
                ];
            }
        }

        echo json_encode($response);
    }

    public function saveImageUrl()
    {
        $response = ['success' => 0];

        if(isset($_FILES['image']['name'])) {
            $mediaManager  = new MediaManager($_FILES['image']);
            if ($mediaManager->moveFile()) {
                $response['success'] = 1;
                $response['file'] = [
                    'name' => $mediaManager->getFileFullName(),
                    'url' => $mediaManager->getFileUrl(),
                    'ext' => $mediaManager->getFileExtension()
                ];
            }
        }

        echo json_encode($response);
    }

}
