<?php


namespace Admin\Classes\CRUD;


class PageFactory implements PageFactoryInterface
{

    public function buildPage($pageName, $path)
    {
        return new Page($pageName, $path);
    }
}