<?php
namespace App\Classes\Crud\Validation;

interface PageValidatorInterface
{
    public function validate($pageName, $template, $pageParent, $pagesRepo, $templatesRepo);
}
