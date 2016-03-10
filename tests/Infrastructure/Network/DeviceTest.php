<?php

namespace Tests\Infrastructure\Network;

use Milhojas\Infrastructure\Network\DeviceIdentity;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;
/**
* Description
*/
class DeviceTest extends \PHPUnit_Framework_Testcase
{

	public function test_it_connects_to_ip()
	{
		$device = new DeviceIdentity('Myself', 'Here', new Ip('127.0.0.1'), new Vendor('Apple', 'iMac'));
		$this->assertTrue($device->isUp());
	}
	
}

?>