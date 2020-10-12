<?php


namespace MiniCMS\Admin\Classes\crud;


interface TemplateFactoryInterface
{
    public function buildTemplate($name, $directory) : TemplateInterface;
}