<?php

namespace Tests\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\Mac;
use Milhojas\Library\ValueObjects\Technical\Ip;

function exec($command, &$output = '', &$return = '')
{
    $output = '? (172.16.0.2) at c4:2c:3:2:ff:b7 on en0 ifscope [ethernet]';
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
        $ip = new Ip('127.0.0.1');
        $mac = Mac::fromIp($ip);
    }

}


 ?>
