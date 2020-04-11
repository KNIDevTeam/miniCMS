<?php $this->extend('layout') ?>

<?php $this->section('title', 'Edycja strony') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="preface">
        <div class="page-name">Nowa strona</div>
    </div>

    <?php
        echo $err;
    ?>
    <form action="adding" method="post">
        <?php crsf() ?>
        <input type="text" name="name" placeholder="name"><br>
        <input type="text" name="template" placeholder="template"><br>
        <input type="text" name="parent" placeholder="parent"><br>
        <a class="fancy-a" id="submitInput"><input type="submit"></a>
    </form>
</main>
<?php $this->endSection() ?>
