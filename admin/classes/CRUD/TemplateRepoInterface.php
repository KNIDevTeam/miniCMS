<?php


namespace Admin\Classes\CRUD;


interface TemplateRepoInterface
{
    public function __construct($startPath, TemplateFactoryInterface $templateFactory);
    public function scanForNew();
    public function getTemplate($name) : TemplateInterface;
}