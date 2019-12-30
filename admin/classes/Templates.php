<?php

    namespace Admin\Classes;

    class Templates
    {
        public $templateList = array();

        public function __construct()
        {
            $dir = ABS_PATH.'/admin/assets/editor/templates';

            $dirStrc = scandir($dir);

            foreach($dirStrc as $dir)
            {
                if (is_dir(ABS_PATH.'/admin/assets/editor/templates/'.$dir) && $dir != '.' && $dir != '..')
                    array_push($this->templateList, $dir);
            }
        }
    }

?>