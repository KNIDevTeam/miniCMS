<?php

namespace Admin\Classes;

use Exception;

class AutoLoader
{
    /**
     * Register AutoLoader class.
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * Auto load class by it's name.
     *
     * @param $className
     *
     * @return bool
     */
    public function autoload($className)
    {
        $fullPathArray = explode('\\', $className);
        $fileName = $fullPathArray[count($fullPathArray)-1];

        if (count($fullPathArray) > 1)
            $fullPath = DIRECTORY_SEPARATOR.strtolower(implode(DIRECTORY_SEPARATOR, array_slice($fullPathArray, 0, count($fullPathArray)-1))).DIRECTORY_SEPARATOR;
        else
            $fullPath = DIRECTORY_SEPARATOR;

        $file = ABS_PATH.$fullPath.$fileName.'.php';

        try {
            if (!file_exists($file))
                throw new Exception('Class '.$className.' does not exist');
            else {
                require_once($file);
                return true;
            }
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
