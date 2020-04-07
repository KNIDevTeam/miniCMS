<!doctype html>
<html lang="pl">
<head>
    <!-- Meta tags -->
    <meta charset='UTF-8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <!-- Title -->
    <title><?php echo $this->getTitle() ?></title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $this->getAsset('assets/css/main.css') ?>" />
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <div class="preface">
                <div class="page-name">mini.pw.edu.pl/~loremipsum</div>
                <div class="page-description"> [tytułstrony] </div>
            </div>
        </header>

        <nav id="menu" class="slide-in">
            <h2>Menu</h2>
            <?php echo $this->getMenu() ?>
        </nav>

        <main class="main-content">
            <?php echo $this->getContent() ?>
        </main>

        <footer id="footer">
            <a href="#">&copy; KNI dev team 2020</a>
        </footer>
    </div>

    <!-- JQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Main script -->
    <script src="<?php echo $this->getAsset('assets/js/main.js') ?>"></script>
</body>
</html>
