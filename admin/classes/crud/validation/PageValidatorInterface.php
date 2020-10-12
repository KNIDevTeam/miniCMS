<?php
namespace MiniCMS\Admin\Classes\crud\validation;

interface PageValidatorInterface
{
    public function validate($pageName, $template, $pageParent, $pagesRepo, $templatesRepo);
}
