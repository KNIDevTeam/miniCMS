<?php

namespace Core\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("Not found", 404);
    }
}