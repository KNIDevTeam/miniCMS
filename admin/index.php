<?php

require('../config.php');
require('classes/AutoLoader.php');

use Admin\Classes as Classes;

$autoLoader = new Classes\AutoLoader();
$request = new Classes\Request();
