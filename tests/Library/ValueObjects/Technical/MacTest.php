<?php

namespace Milhojas\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\Mac;
use Milhojas\Library\ValueObjects\Technical\Ip;

function exec($command, &$output = '', &$return = '')
{
    list($c, $opt, $ip) = explode(' ', $command);
    switch ($ip) {
        case '172.16.0.1':
        $output = '? (172.16.0.1) at c4:2c:3:2:ff:b7 on en0 ifscope [ethernet]';
        break;
        case '172.16.0.43':
        $output = '172.16.0.2 (172.16.0.2) -- no entry';
        break;
        default:
        $output = sprintf('? (%s) at at c4:2c:03:02:ff:b7 on en0 ifscope [ethernet]', $ip);
        break;
    }
    $return = 0;
    return $output;
}

/**
 * Test Mac address
 */
class MacTest extends \PHPUnit_Framework_Testcase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_Invalid_Mac_Address()
    {
        $mac = new Mac('invalid-mac');
    }

    public function test_it_can_handle_valid_but_non_strict_mac()
    {
        $mac = new Mac('c4:2c:3:2:ff:b7');
        $this->assertEquals('c4:2c:03:02:ff:b7', $mac->get());
        $this->assertInstanceOf('Milhojas\Library\ValueObjects\Technical\Mac', $mac);
    }

    public function test_can_get_valid_mac_from_ip()
    {
        $ip = new Ip('172.16.0.1');
        $mac = Mac::fromIp($ip);
        $this->assertEquals('c4:2c:03:02:ff:b7', $mac->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_no_device_on_that_ip()
    {
        $ip = new Ip('172.16.0.2');
        $mac = Mac::fromIp($ip);
    }

}

 ?>
