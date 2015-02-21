<?php

/**
 * Bouncer - A SentoraCP module for only allowing or disallowing control panel login access to certain IP addresses. 
 * @author Bobby Allen (ballen@bobbyallen.me)
 * @copyright (c) 2015, Supared Limited
 * @link https://github.com/supared/sentora-bouncer
 * @license https://github.com/supared/sentora-bouncer/blob/master/LICENSE
 * @version 1.0.0
 */
class Bouncer
{

    private $enforcing = true;
    private $whitelist_enabled = false;
    private $blacklist_enabled = true;
    private $whitelist_addresses = array();
    private $blacklist_addresses = array();

    public function __construct($config = array())
    {
        if (!empty($config)) {
            $this->setConfigItems($config);
        }
    }

    public function gaurd()
    {
        if ($this->enforcing && $this->isClientDenied($_SERVER['REMOTE_ADDR'])) {
            // We must stop this access!
        }
    }

    private function setConfigItems($config_array = array())
    {
        foreach ($config_array as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    private function isClientDenied($address)
    {
        if ($this->blacklist_enabled && in_array($address, $this->blacklist_addresses)) {
            return true;
        }
        if ($this->whitelist_enabled && in_array($address, $this->whitelist_addresses)) {
            return true;
        }
    }
}
