<main id="main">
    <div class="logo">
        <span class="title gradient">Edycja strony</span>
        Nie zna się zasad gry, a jednak się gra
        <div class="bottom-border"></div>
    </div>

    <div class="editor">
        <div class="ce-example">
            <div class="ce-example__content _ce-example__content--small">
                <div id="editorjs"></div>

                <div class="ce-example__button" id="saveButton">
                    editor.save()
                </div>
            </div>
        </div>
        <?php
            echo $pageEditor->openEditor();
        ?>
    </div>
</main>
