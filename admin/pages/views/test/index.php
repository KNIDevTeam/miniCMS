<main>
    <form method="post" action="<?php echo route('testPost') ?>">
        <?php crsf() ?>
        <label>Wpisz cos</label><br>
        cebula <input type="text" name="cebula"> <br>
        maslo <input type="text" name="maslo">

        <button type="submit">OK</button>
    </form>
</main>
