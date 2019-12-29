<?php

namespace Admin\Pages;

use Admin\Classes\ControllerAbstract;
use Admin\Classes\Editor;


class PagesController extends ControllerAbstract
{
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
        $contentDir = ABS_PATH . "/content/pages";
        $listOfPages = scandir($contentDir);

        $this->view->set(['pages' => $listOfPages, 'err' => ""]);
        $this->view->render('pages.show');
    }

    public function addPage()
    {
        $name = $this->getParams['name'];
        $contentDir = ABS_PATH . "/content/pages";
        $listOfPages = scandir($contentDir);
        if (!in_array($name, $listOfPages)) {
            mkdir($contentDir . "/" . $name);
            $err = "";
        } else {
            $err = "Strona o tej nazwie już istnieje";
        }
        $listOfPages = scandir($contentDir);
        $this->view->set(['pages' => $listOfPages, 'err' => $err]);
        $this->view->render('pages.show');
    }

    public function deletePage()
    {
        $name = $this->getParams['name'];
        $contentDir = ABS_PATH . "/content/pages";
        $listOfPages = scandir($contentDir);
        if (in_array($name, $listOfPages)) {
            $this->delete_directory($contentDir."/".$name);
            $err = "";
        } else {
            $err = "Strona o tej nazwie nie istnieje";
        }
        $err = $name;
        $list_of_pages = scandir($contentDir);
        $this->view->set(['pages' => $list_of_pages, 'err' => $err]);
        $this->view->render('pages.show');
    }


    private function delete_directory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        else return false;
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}