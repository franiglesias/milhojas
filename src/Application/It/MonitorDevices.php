<?php

namespace Milhojas\Application\It;

use Milhojas\Library\CommandBus\Command;

/**
* Description
*/
class MonitorDevices implements Command
{
	private $devices;
	
	function __construct(array $devices)
	{
		$this->devices = $devices;
	}
	
	public function getDevices()
	{
		return $this->devices;
	}
}

?>