<?php


namespace MiniCMS\Admin\Classes\Crud;


interface TemplateInterface
{
    public function IsSuccessfullySet();
    public function getName();
    public function getDirectory();
}