<?php

namespace MiniCMS\Admin\Classes\crud;


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

    public function createPage(TemplateInterface $template)
    {
        mkdir($this->getPath());
        //TODO refactor this, for now it copies crap to .info.json file and is unreadable
        $startOfTemplatePath = $template->getDirectory()."/".$template->getName();
        $startOfNewPath = $this->getPath()."/".$this->getName();
        copy($startOfTemplatePath.".template.json", $startOfNewPath.".json");
        copy($startOfTemplatePath.".template.json.cmp", $startOfNewPath.".json.cmp");

        $file = fopen($startOfNewPath.".info.json", 'w');
        fwrite($file, $this->generateInfo($template));
        fclose($file);

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

    private function generateInfo(TemplateInterface $template)
    {
        $result = [];
        $result['name'] = $this->name;
        $result['template'] = $template->getName();
        $result['created'] = date('m/d/Y h:i:s a', time());
        $result['modified'] = date('m/d/Y h:i:s a', time());
        return json_encode($result);
    }

}