<?php

namespace App\Classes;

class ConfigManager
{
    private $values;

    public function __construct()
    {
        $file = $this->getFile();
    }

    private function getFile()
    {
        return file_get_contents(ABS_PATH."config.php");
    }

    private function convert($file)
    {
        foreach (explode("\n", $file) as $line) {

        }
    }
}