<?php

define('TYPE', 'ADMIN');

require "../core/App.php";

$app = new Core\App();
$app->init();

$response = $app->handle(Core\Admin\Kernel::class);

$response->send();