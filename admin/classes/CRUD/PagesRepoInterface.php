<?php


namespace Admin\Classes\CRUD;


interface PagesRepoInterface
{
    public function __construct($startPath);
    public function createPage($name, $parent, $template, $templateRepo);
    public function getPagesNamesList();
    public function getPagePath($name);
    public function deletePage($name);
}