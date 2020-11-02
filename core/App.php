<?php

namespace Core;

use Exception;
use Core\Exceptions\NotFoundException;

class App
{
    private $lang;
    private $request;

    /**
     * App constructor.
     */
    public function __construct()
    {
        session_start();
        $this->setConst();
        $this->setAutoLoader();
        $this->setErrorHandler();
    }

    /**
     * Set needed objects.
     *  Core\Lang
     *  Core\Request
     */
    public function init()
    {
        $this->lang = new Lang((isset($_SESSION['lang']) ? $_SESSION['lang'] : DEFAULT_LANG));
        $this->request = new Request();
    }

    /**
     * Handle current request by specified kernel.
     *
     * @param $kernel
     *
     * @return Response
     */
    public function handle($kernel)
    {
        try {
            $k = new $kernel($this->lang, $this->request);
            return $k->execute();
        } catch(NotFoundException $e) {
            return $this->handleError(404, $e);
        } catch (Exception $e) {
            return $this->handleError(500, $e);
        }
    }

    /**
     * Handle error.
     *
     * @param $code
     * @param $e
     *
     * @return Response
     */
    public function handleError($code, $e)
    {
        if (DEBUG) {
            echo '<h1>Fatal error</h1>';
            echo '<p>Uncaught exception: "' . get_class($e) . '"</p>';
            echo '<p>Message: "' . $e->getMessage() . '"</p>';
            echo '<p>Stack trace:<pre>' . $e->getTraceAsString() . '</pre></p>';
            echo '<p>Thrown in "' . $e->getFile() . '" on line ' . $e->getLine() . '</p>';
            die();
        } else {
            $themeManager = new ThemeManager();
            $themeManager->setLang($this->lang);
            return new Response($themeManager->renderError($code), $code);
        }
    }

    /**
     * Set needed const.
     *  MINI_CMS - basic const, needed to forbid direct php files access.
     *  ABS_PATH - absolute path to application.
     *  BASE_URL - base url for MiniCMS user page (www.mini.pw.edu.pl/~razor)
     *  BASE_ADMIN_URL - base url for MiniCMS admin page (www.mini.pw.edu.pl/~razor/admin
     */
    private function setConst()
    {
        define('MINI_CMS', 'KNI PW MINI');
        define('ABS_PATH', dirname(__FILE__, 2)."/");

        $baseUrls = $this->getBaseUrls();
        define('BASE_URL', $baseUrls['baseUrl']);
        define('BASE_ADMIN_URL', $baseUrls['baseAdminUrl']);

        try {
            $cfg = require_once ABS_PATH."config.php";
            foreach ($cfg as $key => $value)
                define($key, $value);
        } catch (Exception $e) {
            die('Error while loading config file. E: '.$e->getMessage());
        }
    }

    /**
     * Set AutoLoader class.
     */
    private function setAutoLoader()
    {
        try {
            require_once ABS_PATH."core/AutoLoader.php";
        } catch (Exception $e) {
            die('Error while loading AutoLoader class. E: '.$e->getMessage());
        }
    }

    /**
     * Set unhandled exceptions handler.
     */
    private function setErrorHandler()
    {
        if (DEBUG)
            error_reporting(E_ALL);
        else
            error_reporting(0);

        set_error_handler('Core\Error::errorHandler');
        set_exception_handler('Core\Error::exceptionHandler');
    }

    /**
     * Get Base Urls.
     *
     * @return array|string[]
     */
    private function getBaseUrls()
    {
        $path = '';
        $i = 1;
        $paths = explode('/', $_SERVER['SCRIPT_NAME']);

        foreach ($paths as $single)
            if ($i++ != count($paths))
                $path .= $single.'/';

        $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http' ).'://'.$_SERVER['HTTP_HOST'].$path;

        if (TYPE == 'ADMIN')
            return ['baseAdminUrl' => $url, 'baseUrl' => str_replace('admin/', '', $url)];
        else
            return ['baseAdminUrl' => $url."admin/", 'baseUrl' => $url];
    }
}