<?php


namespace Admin\Classes;


interface PagesRepoInterface
{
    public function __construct($startPath);
    public function addPage($name, $directory);
    public function removePage($name);
    public function createPage($name, $parent, $template, $templateRepo);
    public function getPagesList();
    public function deletePage($name);
}