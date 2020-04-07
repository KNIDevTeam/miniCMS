<?php $this->extend('layout') ?>

<?php $this->section('title', 'Edycja strony') ?>

<?php $this->startSection('content') ?>
<main id="main">
<div class="preface">
        <div class="page-name">Edycja strony</div>
    </div>

    <div class="editor">
        <div class="ce-example">
            <div class="ce-example__content _ce-example__content--small">
                <div id="editorjs"></div>
                <div class="editor__button disabled" id="saveButton">
                    Zapisz
                </div>
                <div class="editor__button" id="previewButton">
                    Podgląd
                </div>
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
<?php $this->endSection() ?>
