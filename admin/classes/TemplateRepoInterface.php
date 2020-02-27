<?php


namespace Admin\Classes;


interface TemplateRepoInterface
{
    public function __construct($startPath);
    public function scanForNew();
    public function getTemplate($name);
}