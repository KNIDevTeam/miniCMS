<main id="main">
    <div class="logo">
        <span class="title gradient">Edycja strony</span>
        Nie zna się zasad gry, a jednak się gra
        <div class="bottom-border"></div>
    </div>

    <div class="editor">
        <div class="ce-example">
            <div class="ce-example__content _ce-example__content--small">
                <div class="editor__button" id="saveButton">
                    Zapisz
                </div>
                <div class="editor__button" id="previewButton">
                    Podgląd
                </div>
                <div id="editorjs"></div>
            </div>
        </div>
        <?php
              $_SESSION['pageEditorHandle'] = $pageEditor;
              echo 'You are editing page: '. $pageEditor->getName() . " | " . $pageEditor->getPath();
              if(!is_writable($pageEditor->getPath())) echo " <- not accessible";
              echo $pageEditor->openEditor();
        ?>
    </div>
</main>
