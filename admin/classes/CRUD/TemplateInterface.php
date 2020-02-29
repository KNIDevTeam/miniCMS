<?php


namespace Admin\Classes\CRUD;


interface TemplateInterface
{
    public function IsSuccessfullySet();
    public function getName();
    public function getDirectory();
}