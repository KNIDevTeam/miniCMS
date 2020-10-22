<?php


namespace MiniCMS\Admin\Classes\Crud;


interface TemplateFactoryInterface
{
    public function buildTemplate($name, $directory) : TemplateInterface;
}