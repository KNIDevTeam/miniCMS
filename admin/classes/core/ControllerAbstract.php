<?php

namespace MiniCMS\Admin\Classes\Core;

abstract class ControllerAbstract extends BaseAdminClass implements ControllerInterface
{
    protected $view;
    protected $postParams;
    protected $getParams;

    /**
     * ControllerAbstract constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->view = new View($this->router->getMenu());

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