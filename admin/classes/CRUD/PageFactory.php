<?php


namespace Admin\Classes\CRUD;


class PageFactory implements PageFactoryInterface
{

    public function buildPage($pageName, $path) : PageInterface
    {
        return new Page($pageName, $path);
    }
}