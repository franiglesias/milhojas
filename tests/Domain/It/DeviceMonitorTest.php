<?php

namespace Tests\Domain\It;

use Milhojas\Domain\It\DeviceMonitor;
use Milhojas\Domain\It\Events as Events;
use Milhojas\Domain\It\DeviceIdentity;

use Tests\Application\It\Doubles\DeviceSpy;

class DeviceMonitorTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_monitors_a_device()
	{
		$id = new DeviceIdentity('Device', 'Network');
		$device = DeviceSpy::working($id);
		
		$monitor = new DeviceMonitor();
		$monitor->poll($device);
		$result = $monitor->getEvents();
		$this->assertEquals([new Events\DeviceWasOk($id)], $result);
	}
	
	public function test_it_monitors_a_device_that_fails()
	{
		$id = new DeviceIdentity('Device', 'Network');
		$device = DeviceSpy::isDown($id);
		
		$monitor = new DeviceMonitor();
		$monitor->poll($device);
		$result = $monitor->getEvents();
		$this->assertEquals([new Events\DeviceWentDown($id, 'Device is down')], $result);
	}
	
	public function test_it_monitors_a_device_that_has_several_fails()
	{
		$id = new DeviceIdentity('Device', 'Network');
		$device = DeviceSpy::twoFails($id);
		$monitor = new DeviceMonitor();
		
		$monitor->poll($device);
		$result = $monitor->getEvents();
		$this->assertEquals([
			new Events\DeviceNeedsService($id, 'Device needs service'), 
			new Events\DeviceRanOutOfSupplies($id, 'Device needs supplies')
		], $result);
	}
	
}
?>