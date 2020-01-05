<?php


namespace Admin\Classes;


interface PagesRepoInterface
{
    public function __construct($startPath);
    public function createPage($name, $parent, $template, $templateRepo);
    public function getPagesNamesList();
    public function deletePage($name);
}