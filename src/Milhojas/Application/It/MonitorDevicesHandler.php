<?php

namespace Milhojas\Application\It;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;

use Milhojas\Library\Messaging\EventBus\EventRecorder;
use Milhojas\Domain\It\DeviceMonitor;

/**
* Handles Device Monitorization using a device monitor
*/
class MonitorDevicesHandler implements CommandHandler
{
	private $monitor;
	private $recorder;

	public function __construct(DeviceMonitor $monitor, EventRecorder $recorder)
	{
		$this->monitor = $monitor;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$devices = $command->getDevices();
		foreach ($devices as $device) {
			$this->monitor->poll($device);
			$this->recorder->load($this->monitor->getEvents());
		}
	}
}

?>
