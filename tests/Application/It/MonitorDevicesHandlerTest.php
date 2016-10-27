<?php

namespace Tests\Application\It;

use Tests\Application\Utils\CommandScenario;

use Milhojas\Application\It\MonitorDevices;
use Milhojas\Application\It\MonitorDevicesHandler;
use Milhojas\Domain\It\DeviceIdentity;
use Tests\Application\It\Doubles\DeviceSpy;

use Milhojas\Library\EventBus\EventRecorder;
use Milhojas\Domain\It\DeviceMonitor;
use Milhojas\Domain\It\Events as Events;
/**
* Description
*/
class MonitorDevicesHandlerTest extends CommandScenario
{
	public function test_it_handles_the_command()
	{
		$device = DeviceSpy::isDown(new DeviceIdentity('Device', 'Network'));

		$this
			->sending(new MonitorDevices([$device]))
			->toHandler(new MonitorDevicesHandler(new DeviceMonitor(), $this->recorder))
			->raisesEvent('Milhojas\Domain\It\Events\DeviceWentDown');
	}
	
}

?>
