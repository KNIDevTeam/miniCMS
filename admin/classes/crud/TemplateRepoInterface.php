<?php


namespace MiniCMS\Admin\Classes\Crud;


interface TemplateRepoInterface
{
    public function __construct($startPath, TemplateFactoryInterface $templateFactory);
    public function scanForNew();
    public function getTemplate($name) : TemplateInterface;
    public function ListTemplatesNames();
}