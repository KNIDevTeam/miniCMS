<?php


namespace MiniCMS\Admin\Classes\Crud;


class TemplateFactory implements TemplateFactoryInterface
{

    public function buildTemplate($name, $directory): TemplateInterface
    {
        return new Template($name, $directory);
    }
}