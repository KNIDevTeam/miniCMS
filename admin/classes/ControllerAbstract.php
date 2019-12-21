<?php

namespace Admin\Classes;

abstract class ControllerAbstract
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
     * @param $view
     * @param $router
     */
    public function __construct($request, $view, $router)
    {
        $this->request = $request;
        $this->view = $view;
        $this->router = $router;
        $this->view->setRouter($this->router);

        $this->setParams();
    }

    /**
     * Set parameters (get and post).
     */
    private function setParams()
    {
        if (!empty($this->request->queryString))
            $this->getParams = $this->request->queryString;


        if ($this->request->method == 'post')
            foreach ($_POST as $key => $name)
                $this->postParams[$key] = $name;
    }
}