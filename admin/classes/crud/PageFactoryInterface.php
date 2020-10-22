<?php


namespace MiniCMS\Admin\Classes\Crud;


interface PageFactoryInterface
{
    public function buildPage($pageName, $path): PageInterface;
}