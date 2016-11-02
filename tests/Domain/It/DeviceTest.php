<?php

namespace Tests\Domain\It;

use Milhojas\Domain\It\Device;

/**
 *
 */
class DeviceTests extends \PHPUnit_Framework_Testcase
{
    /**
     * undocumented function summary
     *
     * @expectedException \InvalidArgumentException
     *
     */
    public function testValidIp()
    {
        $device = new Device('Test device', '172.16.0', 'a1:a1:a1:a1:a1:a1');
    }

    /**
     * undocumented function summary
     *
     * @expectedException \InvalidArgumentException
     *
     */

    public function testValidMac()
    {
        $device = new Device('Test Device', '172.16.0.2', 'invalid-mac');

    }

    public function testCanGetMACFromIP()
    {
        $result = exec("arp -n 172.16.0.2");
        preg_match('/(?:[a-f0-9]{1,2}:){5,5}[a-f0-9]{1,2}/', $result, $matches);
        $mac = $matches[0];
        $device = new Device('Test Device', '172.16.0.2', $this->Normalize($mac));
    }

    public function Normalize($mac)
    {
        return implode(':', array_map(function ($i)
        {
            return str_pad($i, 2, '0');
        }, explode(':', $mac)));
    }
}


 ?>
