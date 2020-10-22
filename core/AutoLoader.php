<?php

namespace Core;

use Exception;

class AutoLoader
{
    private $app;

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
     * @throws Exception
     */
    public function autoload($className)
    {
        $fullPathArray = explode('\\', $className);
        $fileName = $fullPathArray[count($fullPathArray)-1];

        if ($fullPathArray[0] != 'App' && $fullPathArray[0] != 'Core')
            return;

        lcfirst($fullPathArray[0]);

        //$fullPathArray = array_slice($fullPathArray, 1);

        if (count($fullPathArray) > 1)
            $fullPath = DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, array_slice($fullPathArray, 0, count($fullPathArray)-1)).DIRECTORY_SEPARATOR;
        else
            $fullPath = DIRECTORY_SEPARATOR;

        $file = ABS_PATH.$fullPath.$fileName.'.php';

        if (!file_exists($file))
            throw new Exception('Class '.$className.' does not exist');
        else
            require_once($file);
    }
}

$autoLoader = new AutoLoader();