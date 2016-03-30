<?php

namespace Milhojas\Application\It;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Library\EventBus\EventRecorder;
use Milhojas\Domain\It\DeviceMonitor;

/**
* Handles Device Monitorization using a device monitor
*/
class MonitorDevicesHandler implements CommandHandler
{
	private $monitor;
	private $recorder;
	
	function __construct(EventRecorder $recorder, DeviceMonitor $monitor)
	{
		$this->monitor = $monitor;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$devices = $command->getDevices();
		foreach ($devices as $device) {
			$this->monitor->poll($device);
			$this->recorder->recordBatch($this->monitor->getEvents());
		}
	}
}

?>