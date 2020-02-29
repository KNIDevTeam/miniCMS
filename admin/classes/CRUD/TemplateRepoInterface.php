<?php


namespace Admin\Classes\CRUD;


interface TemplateRepoInterface
{
    public function __construct($startPath);
    public function scanForNew();
    public function getTemplate($name);
}