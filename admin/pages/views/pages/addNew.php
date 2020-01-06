<?php $this->extend('layout') ?>

<?php $this->section('title', 'Edycja strony') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="logo">
        <span class="title gradient">Edycja strony</span>
        Nie zna się zasad gry, a jednak się gra
        <div class="bottom-border"></div>
    </div>
    <?php
        echo $err."<\br>";
    ?>
    <form action="adding" method="post">
        Name: <input type="text" name="name"><br>
        Template: <input type="text" name="template"><br>
        Parent: <input type="text" name="parent"><br>
        <input type="submit">
    </form>
</main>
<?php $this->endSection() ?>
