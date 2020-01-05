<?php $this->extend('layout') ?>

<?php $this->section('title', 'Edycja strony') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="logo">
        <span class="title gradient">About miniCMS</span>
        Nie zna się zasad gry, a jednak się gra
        <div class="bottom-border"></div>
    </div>

    <ul>
        <?php
            foreach ($pages as $page) {
                if($page == "Home") {
                    echo "<li>".$page." <a href='edit?name=".$page."'>edit</a>";
                }
                else {
                    echo "<li>".$page." <a href='edit?name=".$page."'>edit</a> "." <a href='delete?name=".$page."'>delete</a>";
                }
            }

        ?>
    </ul>
    <a href="add">add new</a>
</main>
<?php $this->endSection() ?>
