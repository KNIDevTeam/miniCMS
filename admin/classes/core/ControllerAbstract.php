<?php

namespace Admin\Classes\Core;

abstract class ControllerAbstract implements ControllerInterface
{
    protected $request;
    protected $view;
    protected $router;
    protected $postParams;
    protected $getParams;

    /**
     * ControllerAbstract constructor.
     *
     * @param $request
     * @param $router
     */
    public function __construct($request, $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->view = new View($this->router->getMenu());
        $this->view->setRouter($this->router);

        $this->setParams();
    }

    /**
     * Set parameters (get and post).
     */
    private function setParams()
    {
        if (count($this->request->queryString) > 0)
            $this->getParams = $this->request->queryString;

        if ($this->request->method == 'post')
            foreach ($_POST as $key => $name)
                $this->postParams[$key] = $name;
    }
}