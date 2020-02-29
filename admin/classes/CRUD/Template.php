<?php

    namespace Admin\Classes\CRUD;

    class Template
    {
        private $directory;
        private $name;
        private $sucess;

        public function __construct($name, $directory)
        {
            $this->sucess = true;
            if(!$this->setName($name))
            {
                $name = '';
                $this->sucess = false;
            }
            if(!$this->setDirectory($directory))
            {
                $directory = '';
                $this->sucess = false;
            }

        }

        public function IsSuccessfullySet()
        {
            return $this->sucess;
        }

        /**
         * @param mixed $directory
         * @return true for now
         */
        public function setDirectory($directory)
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
        public function setName($name)
        {
            $this->name = $name;
            return true;
        }
    }

