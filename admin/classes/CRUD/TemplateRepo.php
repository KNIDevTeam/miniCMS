<?php


namespace Admin\Classes\CRUD;


class TemplateRepo implements TemplateRepoInterface
{
    private $templateList = array();
    private $initialised = false;
    private $TemplatesPath = '';

    public function __construct($startPath)
    {
        $this->TemplatesPath = $startPath;
        #TODO add some validation to getting this path
        return $this->generate();
    }

    public function  scanForNew()
    {
        $tmpInitialised = $this->initialised;
        $this->listTemplateDirectory($this->TemplatesPath);
        $this->initialised = $tmpInitialised;
    }

    public function getTemplate($templname) : TemplateInterface
    {
        return $this->templateList[$templname];
    }

    public function listTemplates()
    {
        return $this->templateList;
    }

    private function generate()
    {
        $startPath = $this->TemplatesPath;
        #Its not in __construct because we may need to move initialization away from object initialization
        $this->initialised = true;
        $this->listTemplateDirectory($startPath);
        return $this->initialised;
    }

    private function addTemplate($name, $directory)
    {
        if(!in_array($name, array_keys($this->templateList)))
            $this->templateList[$name] = new Template($name, $directory);
        else
            $this->initialised = false;
            #TODO maybe we want to accept same templates names and take only first one to consider
            # it's working kind'a this now but it's considered not initialised then
    }

    private function listTemplateDirectory($dirname)
    {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        else return false;
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (is_dir($dirname."/".$file))
                    $this->addTemplate($file, $dirname . "/" . $file);
            }
        }
        closedir($dir_handle);
        return true;
    }
}