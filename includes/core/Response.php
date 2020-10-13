<?php

namespace MiniCMS\includes\core;

class Response
{
    private $code;
    private $content;
    private $headers = [];

    /**
     * Response constructor.
     * Set normal response content and code;
     * If want to redirect, or set json data, don't pass any params.
     *
     * @param null $content
     * @param null $code
     */
    public function __construct($content=null, $code=null)
    {
        $this->content = $content;

        if ($content != null && $code == null) {
            $this->code = 200;
            $this->addHeader('Content-type', 'text/html; charset=UTF-8');
        } else
            $this->code = $code;

        return $this;
    }

    /**
     * Set json data.
     * Status code: 200
     * Header:  Content-type: application/json
     * Content: $content
     *
     * @param $content
     *
     * @return $this
     */
    public function json($content)
    {
        $this->code = 200;
        $this->addHeader('Content-type', 'application/json');
        $this->content = $content;

        return $this;
    }

    /**
     * Set redirect data.
     * Status code: 302
     * Header: Location: $path
     *
     * @param $path
     *
     * @return $this
     */
    public function redirect($path = 'BACK')
    {
        $this->code = 302;
        if ($path == 'BACK')
            $this->addHeader('Location', $_SERVER['HTTP_REFERER']);
        else
            $this->addHeader('Location', $path);

        return $this;
    }

    /**
     * Send response to client browser.
     */
    public function send()
    {
        $this->sendCode();
        $this->sendHeaders();
        $this->sendContent();
    }

    /**
     * Send all headers.
     */
    private function sendHeaders()
    {
        foreach ($this->headers as $header)
            header($header);
    }

    /**
     * Send content;
     */
    private function sendContent()
    {
        echo $this->content;
    }

    /**
     * Send status code;
     */
    private function sendCode()
    {
        http_response_code($this->code);
    }

    /**
     * Add header.
     * Example: addHeader('Content-type', 'text/html');
     *
     * @param $key
     * @param $value
     */
    private function addHeader($key, $value)
    {
        $this->headers[] = $key.': '.$value;
    }
}