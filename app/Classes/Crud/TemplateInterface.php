<?php


namespace App\Classes\Crud;


interface TemplateInterface
{
    public function IsSuccessfullySet();
    public function getName();
    public function getDirectory();
}