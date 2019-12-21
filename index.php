<?php

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
    }


?>