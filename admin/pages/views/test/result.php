<?php $this->extend('layout') ?>

<?php $this->section('title', 'Results') ?>

<?php $this->startSection('content') ?>
<main>
   <h1>Wprowadzona zmienna to: <?php echo $var ?></h1>
</main>
<?php $this->endSection() ?>