<?php


namespace MiniCMS\Admin\Classes\crud;


class PagesRepo implements PagesRepoInterface
{
    private $pagesList = array();
    private $pagesPath;
    private $pageFactory;

    public function __construct($startPath, PageFactoryInterface $pageFactory)
    {
        $this->pagesPath = $startPath;
        $this->pageFactory = $pageFactory;
        $this->listDirectoryPages($this->pagesPath);
        #TODO if there is no Home maybe we need to add one to be sure
    }

    private function addPage($name, $directory)
    {
        $this->pagesList[$name] = $this->pageFactory->buildPage($name, $directory);
        #TODO add some validation and return
    }

    private  function addExistingPage($name, PageInterface $page)
    {
        $this->pagesList[$name] = $page;
        #TODO create validation method for adding page and execute it from both adding methods
    }

    private function removePage($name)
    {
        unset($this->pagesList[$name]);
        #TODO add some validation and return
    }

    public function createPage($name, $parent, $template, TemplateRepoInterface $templateRepo)
    {
        $parentPath = $this->pagesPath;
        if(strcmp($parent, "none")) {
            if (!in_array($parent, array_keys($this->pagesList))) return false;
            $parentPath = $this->pagesList[$parent]->getPath();
        }
        $newPage = new Page($name, $parentPath."/".$name);
        $newPage->createPage($templateRepo->getTemplate($template));
        $this->addExistingPage($name, $newPage);
        return true;
    }

    public function getPagesNamesList()
    {
        $listOfNames = array();
        foreach ($this->pagesList as $name => $page) array_push($listOfNames, $name);
        return $listOfNames;
    }

    public function deletePage($name)
    {
        $this->pagesList[$name]->deletePage();
        $this->removePage($name);
        #TODO again validation and return
    }

    public function getPagePath($name)
    {
        return $this->pagesList[$name]->getPath();
    }
    private function listDirectoryPages($dirname)
    {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        else return false;
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (is_dir($dirname."/".$file)) {
                    $this->addPage($file, $dirname . "/" . $file);
                    $this->listDirectoryPages($dirname . "/" . $file);
                }
            }
        }
        closedir($dir_handle);
        return true;
    }
}