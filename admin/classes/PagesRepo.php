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
        array_push($this->pagesList, new Page($name, $directory));
        #TODO add some validation and return
    }

    public function removePage($name)
    {
        $tmp_array = array();
        foreach ($this->pagesList as $page)
        {
            if(!($page->getName() == $name)) array_push($tmp_array, $page);
        }
        #TODO implement binary searching or hash list
        $this->pagesList = $tmp_array;
        #TODO add some validation and return
    }

    public function createPage($name, $parent, $template, $templateRepo)
    {
        $parentPath = $this->pagesPath;
        $founded = false;
        if($parent) {
            foreach ($this->pagesList as $page)
            {
                if(($page->getName() == $parent)) {
                    $founded = true;
                    $parentPath = $page->getPath();
                }
            }
            #TODO binary search here too :(
        }
        $newPage = new Page($name, $parentPath."/".$name);
        $newPage->createPage();
        array_push($this->pagesList, $newPage);
        #TODO add some validation and return
    }

    public function getPagesList()
    {
        return $this->pagesList;
    }

    public function deletePage($name)
    {
        foreach ($this->pagesList as $page) {
            if(($page->getName() == $name)) {
                $page->deletePage();
                $this->removePage($name);
            }
        }
        #TODO and this freakin binary search again i really should consider ordered list on start
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
        #TODO implement some sorting algorithm that will simplify searching for particular page by name in $pagesList maybe work on ordered list
        return true;
    }
}