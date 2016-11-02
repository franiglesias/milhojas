<?php

namespace Milhojas\Domain\It;

/**
 * Represents a Device managed by this application
 */
class Device
{
    private $name;
    private $ip;
    private $mac;

    public function __construct($name, $ip, $mac)
    {
        $this->checkValidIp($ip);
        $this->checkValidMac($mac);
        $this->name = $name;
        $this->ip = $ip;
        $this->mac = $mac;
    }

    private function checkValidIp($ip)
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid IP', $ip));
        }
    }

    private function checkValidMac($mac)
    {
        if (! filter_var($mac, FILTER_VALIDATE_MAC)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid MAC address', $mac));

        }
    }
}


 ?>
