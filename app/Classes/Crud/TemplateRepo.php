<?php


namespace App\Classes\Crud;


class TemplateRepo implements TemplateRepoInterface
{
    private $templateList = array();
    private $initialised = false;
    private $templateFactory;
    private $TemplatesPath = '';

    public function __construct($startPath, TemplateFactoryInterface $templateFactory)
    {
        $this->templateFactory = $templateFactory;
        $this->TemplatesPath = $startPath;
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

    public function ListTemplatesNames()
    {
        $listOfNames = array();
        foreach ($this->templateList as $name => $template) array_push($listOfNames, $name);
        return $listOfNames;
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
            $this->templateList[$name] = $this->templateFactory->buildTemplate($name, $directory);
        else
            $this->initialised = false;
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