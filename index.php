<?php

define('TYPE', 'USER');

require('config.php');
require('includes/core/AutoLoader.php');

use MiniCMS\Includes\Core as Core;

$autoLoader = new Core\AutoLoader();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('MiniCMS\Includes\Core\Error::errorHandler');
set_exception_handler('MiniCMS\Includes\Core\Error::exceptionHandler');

$request = Core\Request::getInstance();
$pagesManager = new MiniCMS\Includes\PagesManager();

if ($request->path == '')
    $request->redirect('Home');

if ($pagesManager->pageExists()) {
    $themeManager = new Core\ThemeManager();
    $themeManager->addBlock('title', $pagesManager->getCurrentPage()['title']);
    $themeManager->addBlock('menu', $pagesManager->getMenu());
    $themeManager->addBlock('content', $pagesManager->getCurrentPage()['content']);
    $themeManager->render();
} else
    $request->abort('404');
