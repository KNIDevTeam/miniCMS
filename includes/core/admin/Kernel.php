<?php

namespace MiniCMS\Includes\Core\Admin;

use MiniCMS\Includes\Core\Exceptions\NotFoundException;

class Kernel
{
    private $lang;
    private $request;

    /**
     * Kernel constructor.
     *
     * @param $lang
     * @param $request
     */
    public function __construct($lang, $request)
    {
        $this->lang = $lang;
        $this->request = $request;
    }

    /**
     * Execute request.
     *
     * @return mixed
     *
     * @throws NotFoundException
     */
    public function execute()
    {
        $router = new Router($this->request, $this->lang);
        $router->setUp();

        return $router->dispatch();
    }
}