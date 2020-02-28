<?php

define('TYPE', 'USER');

require('config.php');
require('admin/classes/AutoLoader.php');

$autoLoader = new Admin\Classes\AutoLoader();
$utils = new Content\Classes\Utils();

if (DEBUG)
    error_reporting(E_ALL);
else
    error_reporting(0);

set_error_handler('Admin\Classes\Error::errorHandler');
set_exception_handler('Admin\Classes\Error::exceptionHandler');

$request = new Content\Classes\Request();
$pagesManager = new Content\Classes\PagesManager($request->page);

if ($pagesManager->pageExists()) {
    $themeManager = new Content\Classes\ThemeManager($pagesManager->getCurrentPage(), 'no elo');
    $themeManager->render();
} else
    echo 'Error 404';



//$pagesManager = new Content\Classes\PagesManager();

//print_r($pagesManager->getAllPages());

/*
    class Path
    {
        public $path_state;

        public function __construct()
        {
            $this->isPathCorrect();
            $this->isPathEmpty();
        }

        public function isPathCorrect()
        {
            if (!empty($_GET['page']) && !is_dir("./content/pages/".$_GET['page']))
                $this->path_state = "error"; 
        }

        public function isPathEmpty()
        {
            if (empty($_GET['page']))
                $this->path_state = "empty";
        }   

        public function notify()
        {
            if ($this->path_state == "error")
                echo "*Incorect path, try again!";
        }
    }

    $path = new Path();

    if ($path->path_state === "error" || $path->path_state === "empty") {
        echo '<p>Seems that there is some error in the routing module.</br>Specify the path of the page you intend to display:</p>

              <form method="get" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                  <input type="text" name="page">
                  <input type="submit" name="submit" value="Go!">
              </form>

              <p>note: provide the exact name of the folder in "pages"</p>';

        $path->notify();

    } else {
        include './content/themes/header.php';
        include './content/pages/'.$_GET['page'].'/index.php';
        include './content/themes/footer.php';
    }*/


?>