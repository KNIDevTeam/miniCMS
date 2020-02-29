<?php

namespace Admin\Classes\CRUD;


class Page implements PageInterface
{
    private $name;
    private $path;
    private $valid = true;

    public function __construct($pageName, $pagePath) {
        if(!$this->setName($pageName))
        {
            $this->setName("");
            $this->valid = false;
        }
        if(!$this->setPath($pagePath))
        {
            $this->setPath("");
            $this->valid = false;
        }
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function createPage($template)
    {
        mkdir($this->getPath());
        //TODO refactor this, for now it copies crap to .info.json file and is unreadable
        copy($template->getDirectory()."/".$template->getName().".template.json", $this->getPath()."/".$this->getName().".json");
        copy($template->getDirectory()."/".$template->getName().".template.json.cmp", $this->getPath()."/".$this->getName().".json.cmp");
        copy($template->getDirectory()."/".$template->getName().".template.json", $this->getPath()."/".$this->getName().".info.json");
        return true;
    }

    public function deletePage()
    {
        $this->delete_directory($this->path);
    }

    /**
     * @param mixed $name
     * @return bool true if everything went fine false if not
     */
    private function setName($name)
    {
        $this->name = $name;
        return true;
    }

    /**
     * @param mixed $path
     * @return bool true if everything went fine false if not
     */
    private function setPath($path)
    {
        $this->path = $path;
        return true;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        #TODO maybe some flags here to get absolute path or route from pages
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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