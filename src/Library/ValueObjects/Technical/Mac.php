<?php

namespace Milhojas\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\Ip;

/**
 * Represents a MAC address
 */
class Mac
{
    private $mac;

    public function __construct($mac)
    {
        $this->mac = $this->checkValidMac($mac);
    }

    static public function fromIP(Ip $ip)
    {
        return new static(self::getMacFromIp($ip));
    }

    public function get()
    {
        return $this->mac;
    }

    public function __toString()
    {
        return $this->mac;
    }

    private function checkValidMac($mac)
    {
        $mac = $this->normalize($mac);
        if (! filter_var($mac, FILTER_VALIDATE_MAC)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid MAC address', $mac));
        }
        return $mac;
    }

    static private function getMacFromIp($ip)
    {
        $result = exec(sprintf('arp -n %s', $ip));
        preg_match('/(?:[a-f0-9]{1,2}:){5,5}[a-f0-9]{1,2}/', $result, $matches);
        print_r($matches);
        return $matches[0];
    }

    private function normalize($mac)
    {
        return implode(':', array_map(function ($i)
        {
            return str_pad($i, 2, '0', STR_PAD_LEFT);
        }, explode(':', $mac)));

    }

}


 ?>
