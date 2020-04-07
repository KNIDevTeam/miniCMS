<?php


namespace Admin\Classes\CRUD;


interface PageFactoryInterface
{
    public function buildPage($pageName, $path): PageInterface;
}