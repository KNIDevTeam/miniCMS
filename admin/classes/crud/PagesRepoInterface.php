<?php


namespace MiniCMS\Admin\Classes\crud;


interface PagesRepoInterface
{
    public function __construct($startPath, PageFactoryInterface $pageFactory);
    public function createPage($name, $parent, $template, TemplateRepoInterface $templateRepo);
    public function getPagesNamesList();
    public function getPagePath($name);
    public function deletePage($name);
}