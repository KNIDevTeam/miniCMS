<?php


namespace Admin\Classes\CRUD;


interface TemplateFactoryInterface
{
    public function buildTemplate($name, $directory) : TemplateInterface;
}