<?php

define('TYPE', 'USER');

require('config.php');
require('admin/classes/AutoLoader.php');

$autoLoader = new Admin\Classes\AutoLoader();
$utils = new Content\Classes\Utils();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('Admin\Classes\Error::errorHandler');
set_exception_handler('Admin\Classes\Error::exceptionHandler');

$request = new Content\Classes\Request();
$pagesManager = new Content\Classes\PagesManager($request->page);

if ($pagesManager->pageExists()) {
    $themeManager = new Content\Classes\ThemeManager($pagesManager->getCurrentPage(), 'no elo');
    $themeManager->render();
} else
    echo 'Error 404';
