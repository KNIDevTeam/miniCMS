<?php

namespace MiniCMS\Admin\Classes\Core;

use MiniCMS\Includes\Core\BaseClass;

class Router extends BaseClass
{
    private $routes = [];
    private $menu = [];
    private $currentRoute;

    /* Singleton needed start */
    protected static $_instance;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->setUp();
        }

        return self::$_instance;
    }
    /* Singleton needed end */

    /**
     * Set routes for errors.
     */
    public function setErrorsRoutes()
    {
        if (file_exists(ABS_PATH . '/admin/classes/core/ErrorsController.php')) {
            $class = 'MiniCMS\Admin\Classes\Core\ErrorsController';
            $class::setUp($this);
        } else
            die('Errors controller is broken!');
    }

    /**
     * Set routes and menu from controllers and plugins.
     */
    public function setUp()
    {
        $files = scandir(ABS_PATH.'/admin/pages');

        foreach ($files as $file) {
            if (strpos($file, '.php')) {
                $fileName = explode('.', $file)[0];
                $class = 'MiniCMS\Admin\Pages\\'.$fileName;
                $class::setUp($this);
            }
        }
    }

    /**
     * Add route.
     *
     * @param $name
     * @param $path
     * @param $httpMethod
     * @param $controllerMethod
     * @param bool $onlyAjax
     * @param bool $allowedNotCRSF
     */
    public function addRoute($name, $path, $httpMethod, $controllerMethod, $onlyAjax = false, $allowedNotCRSF = false)
    {
        $backtrace = debug_backtrace();
        $this->routes[$name] = [
            'path' => strtolower($path),
            'httpMethod' => strtolower($httpMethod),
            'controllerClass' => $backtrace[1]['class'],
            'controllerMethod' => $controllerMethod,
            'onlyAjax' => $onlyAjax,
            'allowedNotCRSF' => $allowedNotCRSF
        ];
    }

    /**
     * Add item to menu.
     *
     * @param $name
     * @param $routeName
     * @param $icon
     * @param int $parent
     *
     * @throws \Exception
     */
    public function addMenu($name, $routeName, $icon, $parent = -1)
    {
        if ($parent == -1) {
            if ($routeName != '')
                $this->menu[$name] = ['routeName' => $routeName, 'href' => $this->route($routeName), 'icon' => $icon, 'children' => []];
            else
                $this->menu[$name] = ['routeName' => $routeName, 'href' => '', 'icon' => $icon, 'children' => []];
        } else {
            if (isset($this->menu[$parent]))
                $this->menu[$parent]['children'][$name] = ['routeName' => $routeName, 'href' => $this->route($routeName), 'icon' => $icon];
            else
                throw new \Exception("Parent menu: ".$parent." does not exists");
        }
    }

    /**
     * Get menu property.
     *
     * @return array
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Analyze url and execute method from controller.
     */
    public function dispatch()
    {
        if ($route = $this->isRoute()) {
            if (class_exists($route['controllerClass'])) {
                $controller = new $route['controllerClass']();
                if (!$route['onlyAjax'] || $this->request->isAjax) {
                    if (method_exists($controller, $route['controllerMethod'])) {
                        if (!$route['allowedNotCRSF'] && $route['httpMethod'] == 'post' && !$this->security->isValidCRSF()) {
                            throw new \Exception("CRSF token not found");
                        } else {
                            $controllerMethod = $route['controllerMethod'];
                            if (method_exists($controller, 'before'))
                                $controller->before();
                            $controller->$controllerMethod();
                            if (method_exists($controller, 'after'))
                                $controller->after();
                        }
                    } else
                        throw new \Exception("Method: ".$route['controllerMethod']." does not exist");
                } else
                    throw new \Exception("Only ajax calls allowed");
            } else
                throw new \Exception("Class: ".$route['controllerClass']." does not exist");
        } else
            throw new \Exception("Site not found", 404);
    }

    /**
     * Get route path by its name.
     *
     * @param $routeName
     *
     * @return mixed|string
     *
     * @throws \Exception
     */
    public function getRoute($routeName)
    {
        if (isset($this->routes[$routeName]))
            return $this->routes[$routeName]['path'];
        else
            throw new \Exception("Route: ".$routeName." not found");
    }

    /**
     * Return url to route by its name.
     *
     * @param $routeName
     *
     * @return string
     *
     * @throws \Exception
     */
    public function route($routeName)
    {
        return $this->request->baseAdminUrl.$this->getRoute($routeName);
    }

    /**
     * Get current route name;
     *
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->currentRoute;
    }

    /**
     * Check if specific route name is current route.
     *
     * @param $routeName
     *
     * @return bool
     */
    public function isCurrent($routeName)
    {
        return $routeName == $this->currentRoute;
    }

    /**
     * Return class="active" if specific route is current route.
     *
     * @param $routeName
     *
     * @return string
     */
    public function getActive($routeName)
    {
        if ($this->isCurrent($routeName))
            return ' class="active" ';
        else
            return '';
    }

    /**
     * Check if specific query string is route with valid method.
     *
     * @return bool|mixed
     */
    private function isRoute()
    {
        foreach ($this->routes as $name => $route)
            if ($this->request->method == $route['httpMethod'] && $this->request->path == $route['path']) {
                $this->currentRoute = $name;
                return $route;
            }

        return false;
    }
}