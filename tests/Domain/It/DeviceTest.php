<?php

namespace Tests\Domain\It;

use Milhojas\Domain\It\Device;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Mac;
/**
 *
 */
class DeviceTest extends \PHPUnit_Framework_Testcase
{
    /**
     *
     * @expectedException \InvalidArgumentException
     */
    public function testValidIp()
    {
        $device = new Device('Test device', new Ip('172.16.0'), new Mac('a1:a1:a1:a1:a1:a1'));
    }

    /**
     * undocumented function summary
     *
     * @expectedException \InvalidArgumentException
     *
     */
    public function testValidMac()
    {
        $device = new Device('Test Device', new Ip('172.16.0.2'), new Mac('invalid-mac'));
    }

}


 ?>
