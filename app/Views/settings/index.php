<?php $this->section('title', $this->_('settings.title')) ?>

<?php $this->startSection('content') ?>
<main id="main">
    <h2>Zarządzanie ustawieniami strony</h2>
    <?php if(isset($errors)) print_r($errors); ?>
    <?php if(isset($success)) print_r($success); ?>

    <form action="<?php echo $this->router->route("settings.update"); ?>" method="post">
        <?php $this->security->getForm() ?>

        <?php
            foreach($settings as $key => $value) {
                echo '
                <div class="row"
                    <label>'.$key.'</label><br>
                    <input type="text" value="'.$value.'" name="'.$key.'">
                    '.(isset($errors[$key]) ? '<span class="error" style="color: red">'.$errors[$key][0]['error'].'</span>' : '').'
                </div>';
            }
        ?>

        <button type="submit" class="btn">Zapisz</button>
    </form>
</main>
<?php $this->endSection() ?>
