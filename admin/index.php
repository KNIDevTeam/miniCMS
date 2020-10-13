<?php

define('TYPE', 'ADMIN');

require "../includes/core/App.php";

$app = new \MiniCMS\Includes\Core\App();
$app->init();

$response = $app->handle(\MiniCMS\Includes\Core\Admin\Kernel::class);

$response->send();