<?php $this->extend('layout') ?>

<?php $this->section('title', 'Error 500') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="logo">
        <span class="title">ERROR 500</span>
        Ups... Serwer nie mógł wykonać Twojego żądania!
        <div class="bottom-border"></div>
    </div>
</main>
<?php $this->endSection() ?>
