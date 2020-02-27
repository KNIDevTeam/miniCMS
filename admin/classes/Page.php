<?php

namespace Admin\Classes;


class Page
{
    private $name;
    private $path;
    private $valid = true;

    function __construct($pageName, $pagePath) {
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
        copy($template->getDirectory(), $this->getPath()."/content.json");
        #TODO add some default html
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
    public function setName($name)
    {
        $this->name = $name;
        return true;
    }

    /**
     * @param mixed $path
     * @return bool true if everything went fine false if not
     */
    public function setPath($path)
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