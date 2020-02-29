<?php

define('TYPE', 'ADMIN');

session_start();

use Admin\Classes as Classes;

require('../config.php');
require('classes/Functions.php');
require('classes/AutoLoader.php');

$autoLoader = new Classes\AutoLoader();
$utils = new Classes\Utils();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('Admin\Classes\Error::errorHandler');
set_exception_handler('Admin\Classes\Error::exceptionHandler');

$request = new Classes\Request();
$router = new Classes\Router($request);

// Set errors routes
$router->setErrorsRoutes();

// Set routes and menu from controllers and plugins
$router->setUp();

$router->dispatch();
