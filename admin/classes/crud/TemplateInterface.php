<?php


namespace MiniCMS\Admin\Classes\crud;


interface TemplateInterface
{
    public function IsSuccessfullySet();
    public function getName();
    public function getDirectory();
}