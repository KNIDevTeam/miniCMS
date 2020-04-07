<!doctype html>
<html lang="pl">
<head>
    <!-- Meta tags -->
    <meta charset='UTF-8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <!-- Title -->
    <title><?php echo $this->getSection('title') ?></title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php asset('assets/css/main.css') ?>" />
    <link rel="stylesheet" href="<?php asset('assets/css/addpage.css') ?>" />

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/f59842043a.js" crossorigin="anonymous"></script>

    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- Editor -->
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <script src="<?php asset('assets/js/editor/editor.min.js') ?>"></script>
    <script src="<?php asset('assets/js/addpage.js') ?>"></script>
</head>

<body>
    <div id="wrapper">
        <header id="header">
                <div class="title">mini CMS</div>
        </header>

        <nav id="menu" class="slide-in">
            <h2>Menu</h2>
            <?php echo $this->getMenu(); ?>
        </nav>

        <?php echo $this->getSection('content') ?>

        <footer id="footer">
            <a href="#">&copy; KNI dev team</a>
        </footer>
    </div>

    <!-- JQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Main script -->
    <script src="<?php asset('assets/js/main.js') ?>"></script>
</body>
</html>
