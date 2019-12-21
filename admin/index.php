<?php

require('../config.php');
require('classes/AutoLoader.php');

use Admin\Classes as Classes;

$autoLoader = new Classes\AutoLoader();
$security = new Classes\Security();
$request = new Classes\Request();
$view = new Classes\View($request, $security);
$router = new Classes\Router($request, $view, $security);

$router->dispatch();
