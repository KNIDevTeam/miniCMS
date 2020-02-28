<?php

namespace Content\Classes;

class Utils
{
    /**
     * Utils constructor.
     */
    public function __construct()
    {
        if (!defined('BASE_URL'))
            define('BASE_URL', $this->getBaseUrl());

        $GLOBALS['_asset_handler'] = [$this, 'asset'];
        $GLOBALS['_redirect_handler'] = [$this, 'redirect'];
        $GLOBALS['_abort_handler'] = [$this, 'abort'];
    }

    /**
     * Get full path for asset.
     *
     * @param $path
     */
    public function asset($path)
    {
        echo BASE_URL.$path;
    }

    /**
     * Redirect to specific path.
     *
     * @param $path
     */
    public function redirect($path)
    {
        die(header('Location: '.BASE_URL.$path));
    }

    /**
     * Abort with specific code number.
     *
     * @param $codeNum
     */
    public function abort($codeNum)
    {
        $this->redirect('error/'.$codeNum);
    }

    /**
     * Get base url of admin panel.
     *
     * @return string
     */
    private function getBaseUrl()
    {
        $path = '';
        $i = 1;
        $paths = explode('/', $_SERVER['SCRIPT_NAME']);

        foreach ($paths as $single)
            if ($i++ != count($paths))
                $path .= $single.'/';

        return (isset($_SERVER['HTTPS']) ? 'https' : 'http' ).'://'.$_SERVER['HTTP_HOST'].$path;
    }
}