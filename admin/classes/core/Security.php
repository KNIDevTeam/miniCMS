<?php

namespace Admin\Classes\Core;

class Security
{
    private $crsfToken;

    /**
     * Security constructor.
     */
    public function __construct()
    {
        $this->setCRSF();
    }

    /**
     * Return CRSF token.
     *
     * @return mixed
     */
    public function getCRSF()
    {
        return $this->crsfToken;
    }

    /**
     * Check if $_POST['crsf_token'] is valid.
     *
     * @return bool
     */
    public function isValidCRSF()
    {
        return isset($_POST['crsf_token']) && $_POST['crsf_token'] == $this->crsfToken;
    }

    /**
     * Set CRSF token.
     *
     * @throws \Exception
     */
    private function setCRSF()
    {
        if (empty($_SESSION['crsfToken'])) {
            $this->crsfToken = bin2hex(random_bytes(32));
            $_SESSION['crsfToken'] = $this->crsfToken;
        } else
            $this->crsfToken = $_SESSION['crsfToken'];
    }
}