<?php

namespace MiniCMS\Includes\Core\Exceptions;

class NotFoundException extends \Exception
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("Not found", 404);
    }
}