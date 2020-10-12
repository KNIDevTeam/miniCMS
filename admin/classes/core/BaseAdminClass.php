<?php

namespace MiniCMS\Admin\Classes\Core;

use MiniCMS\Includes\Core\BaseClass;

class BaseAdminClass extends BaseClass
{
    protected $router;

    public function __construct()
    {
        parent::__construct();

        $this->router = Router::getInstance();
    }

    protected function router()
    {
        return $this->router;
    }
}