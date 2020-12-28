<?php $this->section('title', 'Nowa strona') ?>

<?php $this->startSection('content') ?>
<main id="main">

    <?php
        echo $err;
    ?>
    <form action="adding" method="post" class="pageform">
        <div class="form-title">Dodaj nową stronę</div>
        <?php $this->security->getForm() ?>
        <input type="text" name="name" placeholder="name"><br>
        <input type="text" name="template" placeholder="template"><br>
        <input type="text" name="parent" placeholder="parent"><br>
        <a class="fancy-a" id="submitInput"><input type="submit"></a>
    </form>
</main>
<?php $this->endSection() ?>
