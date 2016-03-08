<?php

namespace Tests\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Device;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;
/**
* Description
*/
class DeviceTest extends \PHPUnit_Framework_Testcase
{

	public function test_it_connects_to_ip()
	{
		$device = new Device('Myself', 'Here', new Ip('127.0.0.1'), new Vendor('Apple', 'iMac'));
		$this->assertTrue($device->isUp());
	}
	
	/**
	 * @expectedException RuntimeException
	 */
	public function test_it_throws_exception_if_device_is_not_up_in_the_network()
	{
		$device = new Device('Myself', 'Here', new Ip('127.0.30.1'), new Vendor('Apple', 'iMac'));
	}
}

?>