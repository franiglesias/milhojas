<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Domain\It\Device;
use Milhojas\Infrastructure\Network\BaseDevice;

/**
* Represents a simple server
*/
class Server extends BaseDevice
{
	
	function __construct(DeviceIdentity $device, DeviceStatus $status)
	{
		$this->device = $device;
		$this->status = $status;
		$this->messages = array();
	}
	
	public function needsSupplies()
	{
		return false;
	}
	
	public function needsService()
	{
		return (! $this->isUp() || ! $this->isListening() );
	}
	
	
}


?>
