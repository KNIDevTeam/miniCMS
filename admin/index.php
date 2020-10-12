<?php

define('TYPE', 'ADMIN');

session_start();

use MiniCMS\Includes\Core as Core;
use MiniCMS\Admin\Classes\Core as AdminCore;

require('../config.php');
require('../includes/core/AutoLoader.php');

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('MiniCMS\Includes\Core\Error::errorHandler');
set_exception_handler('MiniCMS\Includes\Core\Error::exceptionHandler');

$router = AdminCore\Router::getInstance();

// Set errors routes
$router->setErrorsRoutes();

// Set routes and menu from controllers and plugins
$router->setUp();

$router->dispatch();
