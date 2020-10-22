<?php

define('TYPE', 'USER');

require "core/App.php";

$app = new Core\App();

$app->init();

$response = $app->handle(Core\User\Kernel::class);

$response->send();
