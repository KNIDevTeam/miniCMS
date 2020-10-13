<?php

namespace MiniCMS\Includes\Core;

use ErrorException;

class Error
{
    /**
     * Error handler.
     *
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     *
     * @throws ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0)
            throw new ErrorException($message, 0, $level, $file, $line);
    }

    /**
     * Exception handler.
     *
     * @param $exception
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404)
            $code = 500;
        http_response_code($code);
        if (DEBUG) {
            echo '<h1>Fatal Unhandled error</h1>';
            echo '<p>Uncaught exception: "' . get_class($exception) . '"</p>';
            echo '<p>Message: "' . $exception->getMessage() . '"</p>';
            echo '<p>Stack trace:<pre>' . $exception->getTraceAsString() . '</pre></p>';
            echo '<p>Thrown in "' . $exception->getFile() . '" on line ' . $exception->getLine() . '</p>';
            die();
        } else {
            die("Wystąpił nieoczekiwany błąd");
        }
    }
}