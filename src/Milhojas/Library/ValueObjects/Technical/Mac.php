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
        return new static(self::getMacFromIp($ip->getIp()));
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
        if (!$matches) {
            throw new \InvalidArgumentException(sprintf('Can\'t find a Device at %s', $ip));

        }
        return $matches[0];
    }

    /**
     * normalize MAC string by converting it to array, and padding every element with 00 compacting again
     *
     * Undocumented function long description
     *
     * @param string $mac a MAC string
     * @return return type
     */
    private function normalize($mac)
    {
        return implode(':', array_map(function ($i)
        {
            return str_pad($i, 2, '0', STR_PAD_LEFT);
        }, explode(':', strtolower($mac))));

    }

}


 ?>
