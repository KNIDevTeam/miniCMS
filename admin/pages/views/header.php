<!doctype html>
<html lang="pl">
<head>
    <!-- Meta tags -->
    <meta charset='UTF-8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <!-- Title -->
    <title>mini CMS</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php asset('assets/css/main.css') ?>" />
    <link rel="stylesheet" href="<?php asset('assets/css/addpage.css') ?>" />

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/f59842043a.js" crossorigin="anonymous"></script>

    <!-- Editor -->
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <script src="<?php asset('assets/js/editor/editor.min.js') ?>"></script>
    <script src="<?php asset('assets/js/addpage.js') ?>"></script>
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <span class="title gradient">mini CMS</span>
        </header>

        <nav id="menu">
            <h2>Menu</h2>
            <?php echo $menu; ?>
            <!--<ul>
                <li <?php /*echo $this->router->getActive('home') */?>><a href="<?php /*echo $this->router->route('home') */?>"><i class="fas fa-home"></i>Home</a></li>
                <li <?php /*echo $this->router->getActive('test') */?>><a href="<?php /*echo $this->router->route('test') */?>"><i class="fas fa-pen"></i>Form test</a></li>
                <li <?php /*echo $this->router->getActive('error404') */?>><a href="<?php /*echo $this->router->route('error404') */?>"><i class="fas fa-times"></i>Error404</a></li>
                <li><a class="expand" id="expand1">Rozwijanie</a></li>
                <li class="submenu expand1"><a>Lorem</a></li>
                <li class="submenu expand1"><a>Ipsum</a></li>
                <li class="submenu expand1"><a>Dolor</a></li>
                <li class="submenu expand1"><a>Sit</a></li>
                <li class="submenu expand1"><a>Amet</a></li>
                <li><a class="expand" id="expand2">Mniej</a></li>
                <li class="submenu expand2"><a>Sphinx</a></li>
                <li class="submenu expand2"><a>Of</a></li>
                <li class="submenu expand2"><a>Black</a></li>
                <li class="submenu expand2"><a>Quartz</a></li>
            </ul>-->
        </nav>