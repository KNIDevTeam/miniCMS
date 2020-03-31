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
        $this->pagePath = $this->assetsPath . "templates/default/default.template.json";
        $this->pagePath = str_replace('\\', '/', $this->pagePath);
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

    public function getName()
    {
        return $this->pageName;
    }

    public function setPath($pagePath)
    {
        $this->pagePath = $pagePath;
        $this->pagePath = str_replace('\\', '/', $this->pagePath);
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
        echo $this->pagePath;
        $toolPath = $this->assetsPath . "templates/" . $this->pageType . "/". $this->pageType . ".tools.json";
        $pageTools = file_get_contents($toolPath);
        $pageTools = $this->setAttachesEndpoint($pageTools);
        $saveToolPath = route("savePage");
        $crsfToken = ajaxCrsf();
        return "
			<script src='{$this->getAssetsPath("header.min.js")}'></script><!-- Header -->
			<script src='{$this->getAssetsPath("simple-image.min.js")}'></script><!-- Image -->
			<script src='{$this->getAssetsPath("delimiter.min.js")}'></script><!-- Delimiter -->
			<script src='{$this->getAssetsPath("list.min.js")}'></script><!-- List -->
			<script src='{$this->getAssetsPath("checklist.min.js")}'></script><!-- Checklist -->
			<script src='{$this->getAssetsPath("quote.min.js")}'></script><!-- Quote -->
			<script src='{$this->getAssetsPath("code.min.js")}'></script><!-- Code -->
			<script src='{$this->getAssetsPath("embed.min.js")}'></script><!-- Embed -->
			<script src='{$this->getAssetsPath("table.min.js")}'></script><!-- Table -->
			<script src='{$this->getAssetsPath("link.min.js")}'></script><!-- Link -->
			<script src='{$this->getAssetsPath("warning.min.js")}'></script><!-- Warning -->
			<script src='{$this->getAssetsPath("marker.min.js")}'></script><!-- Marker -->
			<script src='{$this->getAssetsPath("inline-code.min.js")}'></script><!-- Inline Code -->
			<script src='{$this->getAssetsPath("attaches.min.js")}'></script><!-- Inline Code -->
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
			
			<script>
			/**
			 * Saving button
			 */
			const saveButton = document.getElementById('saveButton');
			const previewButton = document.getElementById('previewButton');
			//Swal config
			const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            
            
			
			/**
			 * To initialize the Editor, create a new instance with configuration object
			 * @see docs/installation.md for mode details
			 */
			let editor = new EditorJS({
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
			  data:  {$pageContent},
			  onReady: function(){
				//ready
			  },
			  onChange: function() {
			      saveButton.classList.remove('disabled');
				//change
			  }
			});

			/**
			 * Saving example
			 */
			saveButton.addEventListener('click', function () {
			    if (saveButton.classList.contains('disabled')) return;
			    
			    editor.save().then((outputData) => {
                  //console.log('Article data: ', outputData);
                  $.post( '{$saveToolPath}' , {crsf_token: '{$crsfToken}', path: '{$this->pagePath}', json: JSON.stringify(outputData)})
                .done(resp => {
                    console.log(resp);
                      Toast.fire({
                      icon: 'success',
                      title: 'Poprawnie zapisano'
                    });
                     saveButton.classList.add('disabled');
                });
                }).catch((error) => {
                  console.log('Saving failed: ', error);
                      Toast.fire({
                      icon: 'error',
                      title: 'Błąd zapisu'
                    })
                });
			});
			previewButton.addEventListener('click', function () {
			    editor.save().then((outputData) => {
                  //console.log('Article data: ', outputData);
                  $.post( '{$saveToolPath}' , {crsf_token: '{$crsfToken}', path: '{$this->pagePath}', json: JSON.stringify(outputData)})
                .done(resp => {
                    console.log(resp);
                    Toast.fire({
                      icon: 'info',
                      title: 'Podgląd nie jest jeszcze obsługiwany'
                    });
                });
                }).catch((error) => {
                  console.log('Preview failed: ', error)
                });
			});
			</script>";
    }

    private function getAssetsPath($assetName)
    {
        $modulesPath = BASE_ADMIN_URL . 'assets/js/editor/modules/' . $assetName;
        return str_replace('\\', '/', $modulesPath);
    }

    private function loadFile($pagePath)
    {
        try {
            if ($this->checkFile($pagePath)) return file_get_contents($pagePath);
        } catch (\Exception $e) {
            return file_get_contents($this->assetsPath . "error-loading.en.json");
        }
    }

    public function saveFile($pagePath, $pageContent, $savingMode)
    {
        $compiledPath = $pagePath . ".cmp";
        if($savingMode == "Save")
        {
            if ($this->checkFile($pagePath)) file_put_contents($pagePath, $pageContent);
            $pageCompiler = new Compiler();
            $compiledPage = $pageCompiler->compilePage($pageContent);
            if ($this->checkFile($compiledPath)) file_put_contents($compiledPath, $compiledPage);
        }
        elseif($savingMode == "Preview")
        {
            //To do
        }

    }

    private function checkFile($pagePath)
    {
        $fileIsAccessible = true;
        if (!file_exists($pagePath)) {
            throw new \Exception("The file " . $pagePath . " does not exist");
            //echo "The file {$pagePath} does not exist";
            $fileIsAccessible = false;
        } elseif (!is_readable($pagePath)) {
            throw new \Exception("The file " . $pagePath . " is not readable");
            //echo "The file {$pagePath} is not readable";
            $fileIsAccessible = false;
        } elseif (!is_writable($pagePath)) {
            throw new \Exception("The file " . $pagePath . " is not writable");
            //echo "The file {$pagePath} is not writable";
            $fileIsAccessible = false;
        }

        return $fileIsAccessible;
    }

    private function setAttachesEndpoint($pageTools)
    {
        return str_replace('endpointURL', route('saveFile'), $pageTools);
    }
}
