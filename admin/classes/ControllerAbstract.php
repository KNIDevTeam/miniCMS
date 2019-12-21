<?php

namespace Admin\Classes;

abstract class ControllerAbstract
{
    protected $request;
    protected $view;
    protected $router;

    /**
     * ControllerAbstract constructor.
     *
     * @param $request
     * @param $view
     * @param $router
     */
    public function __construct($request, $view, $router)
    {
        $this->request = $request;
        $this->view = $view;
        $this->router = $router;
        $this->view->setRouter($this->router);
    }
}