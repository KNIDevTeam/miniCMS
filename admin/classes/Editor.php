<?php

namespace Admin\Classes;

class Editor
{
    private $pageName;
    private $pagePath;
    private $pageType;
    private $assetsPath = ABS_PATH . '/admin/assets/editor/';

    public function __construct()
    {
        //Initializing with default values
        $this->pageName = "New page";
        $this->pagePath = $this->assetsPath . "default-content.json";
        $this->pageType = "default";
    }

    public function __destruct()
    {
        //Saving text here
    }

    public function setName($pageName)
    {
        $this->pageName = $pageName;
    }

    public function getName($pageName)
    {
        return $this->pageName;
    }

    public function setPath($pagePath)
    {
        $this->pagePath = $pagePath;
    }

    public function getPath()
    {
        return $this->pagePath;
    }

    public function setType($pageType)
    {
        $this->pageType = $pageType;
    }

    public function getType()
    {
        return $this->pageType;
    }

    public function openEditor()
    {
        $pageContent = $this->loadFile($this->pagePath);
        $toolPath = $this->assetsPath . "templates/" . $this->pageType . ".tools.json";
        $pageTools = file_get_contents($toolPath);
        return "
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/header@latest'></script><!-- Header -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest'></script><!-- Image -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest'></script><!-- Delimiter -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/list@latest'></script><!-- List -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest'></script><!-- Checklist -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/quote@latest'></script><!-- Quote -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/code@latest'></script><!-- Code -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/embed@latest'></script><!-- Embed -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/table@latest'></script><!-- Table -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/link@latest'></script><!-- Link -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/warning@latest'></script><!-- Warning -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/marker@latest'></script><!-- Marker -->
			<script src='https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest'></script><!-- Inline Code -->
			
			<script>
			/**
			 * Saving button
			 */
			const saveButton = document.getElementById('saveButton');
			/**
			 * To initialize the Editor, create a new instance with configuration object
			 * @see docs/installation.md for mode details
			 */
			var editor = new EditorJS({
			  /**
			   * Wrapper of Editor
			   */
			  holder: 'editorjs',
			  /**
			   * Tools list
			   */
			  tools: { {$pageTools}
			  },
			  /**
			   * This Tool will be used as default
			   */
			  // initialBlock: 'paragraph',
			  /**
			   * Initial Editor data
			   */
			  data: { {$pageContent}
			  },
			  onReady: function(){
				saveButton.click();
			  },
			  onChange: function() {
				console.log('something changed');
			  }
			});
			/**
			 * Saving example
			 */
			saveButton.addEventListener('click', function () {
			  const savedPage = editor.save().then((savedData) => {
				 cPreview.show(savedData, document.getElementById(\"output\"));
			  });
			});
			</script>";
    }

    private function loadFile($pagePath)
    {
        try {
            if ($this->checkFile($pagePath)) return file_get_contents($pagePath);
        } catch (\Exception $e) {
            return file_get_contents($this->assetsPath . "error-loading.en.json");
        }
    }

    private function saveFile($pagePath, $pageContent)
    {
        if ($this->checkFile($pagePath)) file_put_contents($pagePath, $pageContent);
    }

    private function checkFile($pagePath)
    {
        $fileIsAccessible = true;
        if (!file_exists($pagePath)) {
            throw new \Exception("The file " . $pagePath . " does not exist");
            echo "The file {$pagePath} does not exist";
            $fileIsAccessible = false;
        } 

        return $fileIsAccessible;
    }
}
