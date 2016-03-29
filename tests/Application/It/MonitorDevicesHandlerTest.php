<?php

namespace Tests\Application\It;

use Milhojas\Application\It\MonitorDevices;
use Milhojas\Application\It\MonitorDevicesHandler;
use Milhojas\Infrastructure\Network\DeviceIdentity;
use Tests\Application\It\Doubles\DeviceSpy;

use Milhojas\Library\EventBus\EventRecorder;
use Milhojas\Domain\It\DeviceMonitor;
use Milhojas\Domain\It\Events as Events;
/**
* Description
*/
class MonitorDevicesHandlerTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_handles_the_command()
	{
		$device = DeviceSpy::isDown(new DeviceIdentity('Device', 'Network'));
		
		$command = new MonitorDevices([$device]);
		
		$recorder = new EventRecorder();
		$monitor = new DeviceMonitor();
		
		$handler = new MonitorDevicesHandler($recorder, $monitor);
		$handler->handle($command);
		
		// assert outcomes
		$expected = [new Events\DeviceIsDown(new DeviceIdentity('Device', 'Network'), 'Device is down')];
		$this->assertEquals($expected, $recorder->retrieve());
	}
	
}

?>