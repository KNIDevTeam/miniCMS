<main>
    <form method="post" action="<?php echo $this->router->route('testPost') ?>">
        <?php echo $this->crsf() ?>
        <label>Wpisz cos</label>
        <input type="text" name="cebula">

        <button type="submit">OK</button>
    </form>
</main>
