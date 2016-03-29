<?php

namespace Tests\Application\It;

use Milhojas\Application\It\MonitorDevices;
use Milhojas\Application\It\MonitorDevicesHandler;

use Tests\Application\It\Doubles\DeviceSpy;
/**
* Description
*/
class MonitorDevicesHandlerTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_handles_the_command()
	{
		$device = DeviceSpy::isDown();
		$command = new MonitorDevices([$device]);
		
		$handler = new MonitorDevicesHandler();
		$handler->handle($command);
		
		// assert outcomes
		$this->assertEquals(array('Device is down'), $device->getReport());
		$this->assertEquals(1, $device->getFails());
	}
	
	public function test_it_handles_the_command_full_working_device()
	{
		$device = DeviceSpy::working();
		$command = new MonitorDevices([$device]);
		
		$handler = new MonitorDevicesHandler();
		$handler->handle($command);
		
		// assert outcomes
		$this->assertEquals(array('', '', '', ''), $device->getReport());
		$this->assertEquals(0, $device->getFails());
	}
	
	public function test_it_monitors_several_devices()
	{
		$device = DeviceSpy::working();
		$badSupplies = DeviceSpy::needingSupplies();
		
		$command = new MonitorDevices([$device, $badSupplies]);
		
		$handler = new MonitorDevicesHandler();
		$handler->handle($command);
		
		// assert outcomes
		$this->assertEquals(array('', '', '', ''), $device->getReport());
		$this->assertEquals(0, $device->getFails());
		$this->assertEquals(array('', '', 'Device needs supplies', ''), $badSupplies->getReport());
		$this->assertEquals(1, $badSupplies->getFails());
	}
}

?>