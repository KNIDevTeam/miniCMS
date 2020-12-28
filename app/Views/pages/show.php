<?php $this->section('title', 'Strony') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="tiles">
        <?php
            foreach ($pages as $page) {
                if($page == "Home") {
                    echo "<div class=\"tile nohover\"><span class=\"tile-title\">".$page."</span>
                    <span class=\"tile-description\"><a href='edit?name=".$page."'><i class=\"fas fa-pen\"></i>edytuj</a></span></div>";
                }
                else {
                    echo "<div class=\"tile nohover\"><span class=\"tile-title\">".$page."</span>
                    <span class=\"tile-description\"><a href='edit?name=".$page."'><i class=\"fas fa-pen\"></i>edytuj</a></br>".
                    "<a href='delete?name=".$page."'><i class=\"far fa-trash-alt\"></i>usuń</a></span></div>";
                }
            }

        ?>
    </div>
    <a href="add" class="fancy-a" id="addNewPage">Dodaj nową stronę</a>
</main>
<?php $this->endSection() ?>
