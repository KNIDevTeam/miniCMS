<?php
	class Editor
	{
		public $pageName;
		public $pagePath;
		
		function __construct()
		{
			//Initializing with default values
			$this->pageName = "New page";
			$this->pagePath = "default-content.json";
		}
		
		function __destruct()
		{
			//Saving text here
		}
		
		function setName($pageName)
		{
			$this->pageName = $pageName;
		}
		
		function getName($pageName)
		{
			return $this->pageName;
		}
		
		function setPath($pagePath)
		{
			$this->pagePath = $pagePath;
		}
		
		function getPath()
		{
			return $this->pagePath;
		}
		
		function openEditor()
		{
			$pageContent = file_get_contents($this->pagePath);
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
			
			<script src='editor.js'></script>
			
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
			  tools: {
				/**
				 * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
				 */
				header: {
				  class: Header,
				  inlineToolbar: ['link'],
				  config: {
					placeholder: 'Header'
				  },
				  shortcut: 'CMD+SHIFT+H'
				},
				/**
				 * Or pass class directly without any configuration
				 */
				image: {
				  class: SimpleImage,
				  inlineToolbar: ['link'],
				},
				list: {
				  class: List,
				  inlineToolbar: true,
				  shortcut: 'CMD+SHIFT+L'
				},
				checklist: {
				  class: Checklist,
				  inlineToolbar: true,
				},
				quote: {
				  class: Quote,
				  inlineToolbar: true,
				  config: {
					quotePlaceholder: 'Enter a quote',
					captionPlaceholder: 'Quote\'s author',
				  },
				  shortcut: 'CMD+SHIFT+O'
				},
				warning: Warning,
				marker: {
				  class:  Marker,
				  shortcut: 'CMD+SHIFT+M'
				},
				code: {
				  class:  CodeTool,
				  shortcut: 'CMD+SHIFT+C'
				},
				delimiter: Delimiter,
				inlineCode: {
				  class: InlineCode,
				  shortcut: 'CMD+SHIFT+C'
				},
				linkTool: LinkTool,
				embed: Embed,
				table: {
				  class: Table,
				  inlineToolbar: true,
				  shortcut: 'CMD+ALT+T'
				},
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
	
	echo $pageEditor->openEditor();
	?>
</body>
</html>