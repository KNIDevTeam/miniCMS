<?php


namespace Admin\Classes\crud;


class PageFactory implements PageFactoryInterface
{
    public function buildPage($pageName, $path) : PageInterface
    {
        return new Page($pageName, $path); // TODO replace this with proper spaces to _ changing
    }
}