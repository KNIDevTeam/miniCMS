<?php if(!defined('MINI_CMS')) die('Math is golden') ?>

<!doctype html>
<html lang="pl">
<head>
    <!-- Meta tags -->
    <meta charset='UTF-8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <!-- Title -->
    <title><?php echo $this->getBlock('title') ?></title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $this->asset('assets/user/css/styles.css') ?>" />
</head>

<body>
<div id="wrapper">
    <header id="header">
        <div class="preface">
            <div class="flex-start">
                <div class="page-name"><?php echo SITE_NAME ?></div>
                <div class="page-description"> <?php echo $this->getBlock('title') ?> </div>
            </div>
        </div>

        <img class="logo" src="<?php echo $this->asset('assets/images/logo_mini.png') ?>"></img>
    </header>

    <main>
        <?php echo $this->getBlock('content') ?>
        <a href="<?php echo BASE_URL.'Home'; ?>">Powrót</a>
    </main>

    <footer id="footer">
        <div class="flex-start bold">miniCMS</div>
        <a href="#" class="flex-end">&copy; KNI dev team 2020</a>
    </footer>
</div>

</body>
</html>
