<?php

define('TYPE', 'USER');

require "includes/core/App.php";

$app = new \MiniCMS\Includes\Core\App();
$app->init();

$response = $app->handle(\MiniCMS\Includes\Core\User\Kernel::class);

$response->send();
