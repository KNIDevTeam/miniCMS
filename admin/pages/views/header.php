<!doctype html>
<html>
<head>
    <meta charset='UTF-8'/>
    <title>mini CMS</title>
    <link rel="stylesheet" href="<?php echo $this->asset('assets/css/main.css') ?>" />
    <script src="https://kit.fontawesome.com/f59842043a.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <div class="links">
                <div class="login">
                    <a href="#">Logowanie</a>
                </div>
            </div>
        </header>

        <nav id="menu">
            <ul>
                <li <?php echo $this->router->getActive('home') ?>><a href="<?php echo $this->router->route('home') ?>"><i class="fas fa-home"></i>Home</a></li>
                <li <?php echo $this->router->getActive('test') ?>><a href="<?php echo $this->router->route('test') ?>"><i class="fas fa-pen"></i>Form test</a></li>
                <li <?php echo $this->router->getActive('error404') ?>><a href="<?php echo $this->router->route('error404') ?>"><i class="fas fa-danger"></i>Error404</a></li>
            </ul>
        </nav>
