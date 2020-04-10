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
        Name: <input type="text" name="name"><br>
        Template: <input type="text" name="template"><br>
        Parent: <input type="text" name="parent"><br>
        <a class="fancy-a" id="submitInput"><input type="submit"></a>
    </form>
</main>
<?php $this->endSection() ?>
