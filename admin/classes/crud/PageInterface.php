<?php


namespace Admin\Classes\crud;


interface PageInterface
{
    public function isValid();
    public function createPage(Template $template);
    public function deletePage();
    public function getPath();
    public function getName();
}