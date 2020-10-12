<?php $this->section('title', 'Edycja strony') ?>

<?php $this->startSection('content') ?>
<main id="main">

    <div class="editor">
        <div class="ce-example">
            <div class="ce-example__content _ce-example__content--small">
                <div id="editorjs"></div>
                <div class="center">
                <a class="fancy-a" id="saveButton">
                    Zapisz
                </a>
                <a class="fancy-a" id="previewButton">
                    Podgląd
                </a>
                </div>
            </div>
        </div>
        <div id="text">
        <?php
              $_SESSION['pageEditorHandle'] = $pageEditor;
              echo 'You are editing page: '. $pageEditor->getName() . " | " . $pageEditor->getPath();
              if(!is_writable($pageEditor->getPath())) echo " <- not accessible";
              echo $pageEditor->openEditor();
        ?>
        </div>
    </div>
</main>
<?php $this->endSection() ?>
