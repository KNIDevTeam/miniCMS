<?php
	class Editor
	{
		private $pageName;
		private $pagePath;
		private $pageType;
		
		public function __construct()
		{
			//Initializing with default values
			$this->pageName = "New page";
			$this->pagePath = "default-content.json";
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
            $toolPath = "templates/". $this->pageType . ".tools.json";
            $pageTools =  file_get_contents($toolPath);
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
			
			<script src='editor.min.js'></script>
			
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
            try
            {
                if($this->checkFile($pagePath) == TRUE) return file_get_contents($pagePath);
            }
            catch(Exception $e)
            {
                return file_get_contents("error-loading.en.json");
            }
        }

        private function saveFile($pagePath, $pageContent)
        {
            if($this->checkFile($pagePath) == TRUE) file_put_contents($pagePath, $pageContent);
        }

        private function checkFile($pagePath)
        {
            $file_is_accessible = TRUE;
            if(file_exists($pagePath) == FALSE)
            {
                throw new Exception("The file {$pagePath} does not exist");
                //echo "The file {$pagePath} does not exist";
                $file_is_accessible = FALSE;
            }
            elseif(is_readable($pagePath) == FALSE)
            {
                throw new Exception("The file {$pagePath} is not readable");
                //echo "The file {$pagePath} is not readable";
                $file_is_accessible = FALSE;
            }
            elseif(is_writable($pagePath) == FALSE)
            {
                throw new Exception("The file {$pagePath} is not writable");
                //echo "The file {$pagePath} is not writable";
                $file_is_accessible = FALSE;
            }

            return $file_is_accessible;
        }
	}
?>

<!-- HTML to be removed soon -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Editor.js 🤩🧦🤨 example</title>
  <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
  <link href="assets/demo.css" rel="stylesheet">
  <script src="assets/json-preview.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
  <div class="ce-example">
    <div class="ce-example__header">
      <a class="ce-example__header-logo" href="https://codex.so/editor">miniCMS - editor</a>

      <div class="ce-example__header-menu">
        <a href="https://github.com/editor-js" target="_blank">Plugins</a>
        <a href="https://editorjs.io/usage" target="_blank">Usage</a>
        <a href="https://editorjs.io/configuration" target="_blank">Configuration</a>
        <a href="https://editorjs.io/creating-a-block-tool" target="_blank">API</a>
      </div>
    </div>
    <div class="ce-example__content _ce-example__content--small">
      <div id="editorjs"></div>

      <div class="ce-example__button" id="saveButton">
        editor.save()
      </div>
    </div>
    <div class="ce-example__output">
      <pre class="ce-example__output-content" id="output"></pre>

      <div class="ce-example__output-footer">
        <a href="https://codex.so" style="font-weight: bold;">KNI dev team<br></a>
		<a href="https://codex.so" style="font-weight: bold;">Editor created by Codex team</a>
      </div>
    </div>
  </div>

  <!-- Loading editor -->
  <?php
	$pageEditor = new Editor();
	$pageEditor->setName('Test');
	$pageEditor->setPath('default-content.json');
    $pageEditor->setType('default');
	echo $pageEditor->openEditor();

	?>
</body>
</html>