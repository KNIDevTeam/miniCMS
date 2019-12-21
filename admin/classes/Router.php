<?php

namespace Admin\Classes;

class Router
{
    private $routes = [];
    private $request;
    private $security;
    private $currentRoute;

    /**
     * Router constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->security = new Security();
    }

    /**
     * Set routes for errors.
     */
    public function setErrorsRoutes()
    {
        if (file_exists(ABS_PATH . '/admin/classes/ErrorsController.php')) {
            $class = 'Admin\Classes\ErrorsController';
            $class::setRoutes($this);
        } else
            die('Errors controller is broken!');
    }

    /**
     * Set routes from controllers and plugins.
     */
    public function setRoutes()
    {
        $files = scandir(ABS_PATH.'/admin/pages');

        foreach ($files as $file) {
            if (strpos($file, '.php')) {
                $fileName = explode('.', $file)[0];
                $class = 'Admin\Pages\\'.$fileName;
                $class::setRoutes($this);
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
     */
    public function addRoute($name, $path, $httpMethod, $controllerMethod)
    {
        $backtrace = debug_backtrace();
        $this->routes[$name] = ['path' => strtolower($path), 'httpMethod' => strtolower($httpMethod), 'controllerClass' => $backtrace[1]['class'], 'controllerMethod' => $controllerMethod];
    }

    /**
     * Analyze url and execute method from controller.
     */
    public function dispatch()
    {
        if ($route = $this->isRoute()) {
            if (class_exists($route['controllerClass'])) {
                $controller = new $route['controllerClass']($this->request, $this);
                if (method_exists($controller, $route['controllerMethod'])) {
                    if ($route['httpMethod'] == 'post' && !$this->security->isValidCRSF()) {
                        throw new \Exception("CRSF token not found");
                    } else {
                        $controllerMethod = $route['controllerMethod'];
                        $controller->$controllerMethod();
                    }
                } else
                    throw new \Exception("Method: ".$route['controllerMethod']." does not exist");
            } else
                throw new \Exception("Class: ".$route['controllerC  lass']." does not exist");
        } else
            throw new \Exception("Site not found", 404);
    }

    /**
     * Get route path by its name.
     *
     * @param $routeName
     *
     * @return mixed|string
     */
    public function getRoute($routeName)
    {
        return isset($this->routes[$routeName]) ? $this->routes[$routeName]['path'] : 'error/404';
    }

    /**
     * Return url to route by its name.
     *
     * @param $routeName
     *
     * @return string
     */
    public function route($routeName)
    {
        return BASE_URL.$this->getRoute($routeName);
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
            if ($this->request->method == $route['httpMethod'] && $this->request->routePath == $route['path']) {
                $this->currentRoute = $name;
                return $route;
            }

        return false;
    }
}