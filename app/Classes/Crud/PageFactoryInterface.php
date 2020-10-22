<?php


namespace App\Classes\Crud;


interface PageFactoryInterface
{
    public function buildPage($pageName, $path): PageInterface;
}