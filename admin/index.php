<?php

define('TYPE', 'ADMIN');

session_start();

use Admin\Classes\Core as Core;

require('../config.php');
require('classes/core/Functions.php');
require('classes/core/AutoLoader.php');

$autoLoader = new Core\AutoLoader();
$utils = new Core\Utils();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('Admin\Classes\Core\Error::errorHandler');
set_exception_handler('Admin\Classes\Core\Error::exceptionHandler');

$request = new Core\Request();
$router = new Core\Router($request);

// Set errors routes
$router->setErrorsRoutes();

// Set routes and menu from controllers and plugins
$router->setUp();

$router->dispatch();
