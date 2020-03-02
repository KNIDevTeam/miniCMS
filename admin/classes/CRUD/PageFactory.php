<?php


namespace Admin\Classes\CRUD;


class PageFactory implements PageFactoryInterface
{
    public function buildPage($pageName, $path) : PageInterface
    {

        return new Page(str_replace(" ", "%20", $pageName), $path); // TODO replace this with proper spaces to _ changing
    }
}