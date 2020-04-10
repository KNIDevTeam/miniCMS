<?php


namespace Admin\Classes\crud;


interface PageFactoryInterface
{
    public function buildPage($pageName, $path): PageInterface;
}