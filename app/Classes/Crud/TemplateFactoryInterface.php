<?php


namespace App\Classes\Crud;


interface TemplateFactoryInterface
{
    public function buildTemplate($name, $directory) : TemplateInterface;
}