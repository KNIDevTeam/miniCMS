<?php

define('TYPE', 'USER');

require('config.php');
require('includes/AutoLoader.php');

$autoLoader = new MiniCMS\Includes\AutoLoader();
$utils = new MiniCMS\Includes\Utils();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('MiniCMS\Admin\Classes\Core\Error::errorHandler');
set_exception_handler('MiniCMS\Admin\Classes\Core\Error::exceptionHandler');

$request = new MiniCMS\Content\Classes\Request();
$pagesManager = new MiniCMS\Content\Classes\PagesManager($request->page);

if ($request->page == '')
    header('Location: Home');

if ($pagesManager->pageExists()) {
    $themeManager = new MiniCMS\Includes\ThemeManager();
    $themeManager->addBlock('title', $pagesManager->getCurrentPage()['title']);
    $themeManager->addBlock('menu', $pagesManager->getMenu());
    $themeManager->addBlock('content', $pagesManager->getCurrentPage()['content']);
    $themeManager->render();
} else
    echo 'Error 404';
