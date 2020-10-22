<?php

namespace Core\Admin;

abstract class ControllerAbstract implements ControllerInterface
{
    protected $postParams;
    protected $getParams;

    protected $view;
    protected $request;
    protected $router;
    protected $lang;

    /**
     * ControllerAbstract constructor.
     *
     * @param $request
     * @param $router
     * @param $lang
     */
    public function __construct($request, $router, $lang)
    {
        $this->request = $request;
        $this->router = $router;
        $this->view = new View($request, $router, $lang);
        $this->lang = $lang;

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