<?php

    namespace Admin\Classes\crud;

    class Template implements TemplateInterface
    {
        private $directory;
        private $name;
        private $success;

        public function __construct($name, $directory)
        {
            $this->success = true;
            if(!$this->setName($name))
            {
                $name = '';
                $this->success = false;
            }
            if(!$this->setDirectory($directory))
            {
                $directory = '';
                $this->success = false;
            }

        }

        public function IsSuccessfullySet()
        {
            return $this->success;
        }

        /**
         * @param mixed $directory
         * @return true for now
         */
        private function setDirectory($directory)
        {
            $this->directory = $directory;
            return true;
        }

        /**
         * @return mixed
         */
        public function getDirectory()
        {
            return $this->directory;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         * @return true for now
         */
        private function setName($name)
        {
            $this->name = $name;
            return true;
        }
    }

