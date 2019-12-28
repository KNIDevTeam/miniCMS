<main id="main">
    <div class="logo">
        <span class="title gradient">About miniCMS</span>
        Nie zna się zasad gry, a jednak się gra
        <div class="bottom-border"></div>
    </div>

    <ul>
        <?php
            for($i = 2; $i < count($pages); $i++) {
                if($pages[$i] == "Home") {
                    echo "<li>".$pages[$i]." <a href='edit?name=".$pages[$i]."'>edit</a>";
                }
                else {
                    echo "<li>".$pages[$i]." <a href='edit?name=".$pages[$i]."'>edit</a> "." <a href='delete?name=".$pages[$i]."'>delete</a>";
                }
            }

        ?>
    </ul>

    Add new page:
    <form action="add" method="get">
        Name: <input type="text" name="name"><br>
        <?php
            echo $err."<\br>";
        ?>
        <input type="submit">
    </form>
</main>
