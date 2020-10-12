<?php


namespace MiniCMS\Admin\Classes\crud;


interface PageFactoryInterface
{
    public function buildPage($pageName, $path): PageInterface;
}