<?php

namespace MiniCMS\Includes\Core;

class Security
{
    private $crsfToken;

    /* Singleton needed start */
    protected static $_instance;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->setCRSF();
        }

        return self::$_instance;
    }
    /* Singleton needed end */

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
     * Get CRSF token for form.
     */
    public function getForm()
    {
        echo '<input type="hidden" name="crsf_token" value="'.$this->crsfToken.'"/>';
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