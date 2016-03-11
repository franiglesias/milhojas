<?php

namespace Tests\Infrastructure\Network;

use Milhojas\Infrastructure\Network\DeviceIdentity;
use Milhojas\Infrastructure\Network\BaseDevice;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;
use Milhojas\Infrastructure\Network\Device;
use Milhojas\Infrastructure\Network\DeviceReporter;
use Milhojas\Infrastructure\Network\DeviceIdentitiy;

/**
* Description
*/
class TestingDevice extends BaseDevice
{
}

class DumbDriver  {
	public function needsSupplies() {return 'supplies';}
	public function needsService() {return 'service';}
	public function getReport() {return 'report';}
	public function requestStatus(DeviceReporter $reporter) {}
}
/**
* Description
*/
class DeviceTest extends \PHPUnit_Framework_Testcase
{

	public function test_it_connects_to_ip()
	{
		$id = new DeviceIdentity('Myself', 'Here', new Ip('127.0.0.1'), new Vendor('Apple', 'iMac'));
		$device = new TestingDevice($id, new DumbDriver());
		$this->assertTrue($device->isUp());
	}
	
	public function test_it_can_report_that_needs_supplies()
	{
		$id = new DeviceIdentity('Myself', 'Here', new Ip('127.0.0.1'), new Vendor('Apple', 'iMac'));
		$device = new TestingDevice($id, new DumbDriver());
		$this->assertEquals('supplies', $device->needsSupplies());
		
	}
	
}

?>