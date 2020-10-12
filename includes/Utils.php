<?php

namespace MiniCMS\Includes;

class Utils
{
    /**
     * Utils constructor.
     */
    public function __construct()
    {
        if (!defined('BASE_ADMIN_URL'))
            define('BASE_ADMIN_URL', $this->getBaseAdminUrl());

        if (!defined('BASE_URL'))
            define('BASE_URL', substr(BASE_ADMIN_URL, 0, strpos(BASE_ADMIN_URL, 'admin')));

        $GLOBALS['_asset_handler'] = [$this, 'asset'];
        $GLOBALS['_crsf_handler'] = [$this, 'crsf'];
        $GLOBALS['_ajax_crsf_handler'] = [$this, 'ajaxCrsf'];
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
        echo BASE_ADMIN_URL.$path;
    }

    /**
     * Generate crsf token in input.
     */
    public function crsf()
    {
        $security = new Security();

        echo '<input type="hidden" name="crsf_token" value="'.$security->getCRSF().'"/>';
    }

    /**
     * Generate crsf token for ajax.
     */
    public function ajaxCrsf()
    {
        $security = new Security();

        return $security->getCRSF();
    }

    /**
     * Redirect to specific path.
     *
     * @param $path
     */
    public function redirect($path)
    {
        die(header('Location: '.BASE_ADMIN_URL.$path));
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
    private function getBaseAdminUrl()
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