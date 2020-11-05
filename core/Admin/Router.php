<?php

namespace Core\Admin;

use Exception;
use Core\Exceptions\NotFoundException;
use Core\Response;
use Core\Security;

class Router
{
    private const CONTROLLERS_PATH = ABS_PATH.'app/Controllers';

    private $routes = [];
    private $menu = [];
    private $currentRoute;

    private $request;
    private $security;
    private $lang;

    /**
     * Router constructor.
     *
     * @param $request
     * @param $lang
     */
    public function __construct($request, $lang)
    {
        $this->request = $request;
        $this->security = Security::getInstance();
        $this->lang = $lang;
    }

    /**
     * Set routes and menu from controllers and plugins.
     */
    public function setUp()
    {
        $files = scandir(self::CONTROLLERS_PATH);

        foreach ($files as $file) {
            if (strpos($file, '.php')) {
                $fileName = explode('.', $file)[0];
                $class = 'App\Controllers\\'.$fileName;
                $class::setUp($this, $this->lang);
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
     * @throws Exception
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
                throw new Exception("Parent menu: ".$parent." does not exists");
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
     *
     * @return mixed | Response
     *
     * @throws NotFoundException
     * @throws Exception
     */
    public function dispatch()
    {
        if ($route = $this->isRoute()) {
            if (class_exists($route['controllerClass'])) {
                $controller = new $route['controllerClass']($this->request, $this, $this->lang);

                if (!$route['onlyAjax'] || $this->request->isAjax) {
                    if (method_exists($controller, $route['controllerMethod'])) {
                        if (!$route['allowedNotCRSF'] && $route['httpMethod'] == 'post' && !$this->security->isValidCRSF()) {
                            throw new Exception("CRSF token not found");
                        } else {
                            $controllerMethod = $route['controllerMethod'];

                            if (method_exists($controller, 'before'))
                                $controller->before();

                            $response =  $controller->$controllerMethod();

                            if (method_exists($controller, 'after'))
                                $controller->after();

                            return $response;
                        }
                    } else
                        throw new Exception("Method: ".$route['controllerMethod']." does not exist");
                } else
                    throw new Exception("Only ajax calls allowed");
            } else
                throw new Exception("Class: ".$route['controllerClass']." does not exist");
        } else
            throw new NotFoundException();
    }

    /**
     * Get route path by its name.
     *
     * @param $routeName
     *
     * @return mixed|string
     *
     * @throws Exception
     */
    public function getRoute($routeName)
    {
        if (isset($this->routes[$routeName]))
            return $this->routes[$routeName]['path'];
        else
            throw new Exception("Route: ".$routeName." not found");
    }

    /**
     * Return url to route by its name.
     *
     * @param $routeName
     *
     * @return string
     *
     * @throws Exception
     */
    public function route($routeName)
    {
        return BASE_ADMIN_URL.$this->getRoute($routeName);
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