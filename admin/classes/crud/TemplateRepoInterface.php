<?php


namespace Admin\Classes\crud;


interface TemplateRepoInterface
{
    public function __construct($startPath, TemplateFactoryInterface $templateFactory);
    public function scanForNew();
    public function getTemplate($name) : TemplateInterface;
    public function ListTemplatesNames();
}