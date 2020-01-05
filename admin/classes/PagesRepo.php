<?php


namespace Admin\Classes;


class PagesRepo implements PagesRepoInterface
{
    private $pagesList = array();
    private $pagesPath;

    public function __construct($startPath)
    {
        $this->pagesPath = $startPath;
        $this->listDirectoryPages($this->pagesPath);
    }

    public function addPage($name, $directory)
    {
        $this->pagesList[$name] = new Page($name, $directory);
        #TODO add some validation and return
    }

    private  function addExistingPage($name, $page)
    {
        $this->pagesList[$name] = $page;
        #TODO create validation method for adding page and execute it from both adding methods
    }

    public function removePage($name)
    {
        unset($this->pagesList[$name]);
        #TODO add some validation and return
    }

    public function createPage($name, $parent, $template, $templateRepo)
    {
        $parentPath = $this->pagesPath;
        if($parent)
            if(!in_array($parent, array_keys($this->pagesList))) throw new \Exception('No such page'); #It's enough validation for now I think but i can be wrong
            $parentPath = $this->pagesList[$parent]->getPath();
        $newPage = new Page($name, $parentPath."/".$name);
        $newPage->createPage();
        $this->addExistingPage($name, $newPage);
        #TODO add some validation and return
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