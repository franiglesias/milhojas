<?php

namespace Milhojas\Application\It;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
/**
* Description
*/
class MonitorDevicesHandler implements CommandHandler
{
	
	function __construct()
	{
	}
	
	public function handle(Command $command)
	{
		$devices = $command->getDevices();
		foreach ($devices as $device) {
			if (!$device->isUp()) {
				continue;
			}
			$device->isListening();
			$device->needsSupplies();
			$device->needsService();
		}
	}
}

?>