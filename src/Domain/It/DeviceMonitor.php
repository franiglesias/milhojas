<?php

namespace Milhojas\Domain\It;

use Milhojas\Infrastructure\Network\Device;
use Milhojas\Domain\It\Events as Events;
/**
* Description
*/
class DeviceMonitor
{
	private $events;
	private $device;
	
	public function poll(Device $device)
	{
		$this->device = $device;
		$fails = 0;
		if (! $this->device->isUp()) {
			$this->events[] = new Events\DeviceIsDown($this->device->getIdentity(), $this->device->getReport());
		}
		if (! $this->device->isListening()) {
			$this->events[] = new Events\DeviceIsNotListening($this->device->getIdentity(), $this->device->getReport());
		}
		if ($this->device->needsService()) {
			$this->events[] = new Events\DeviceNeedsService($this->device->getIdentity(), $this->device->getReport());
		}
		if ($this->device->needsSupplies()) {
			$this->events[] = new Events\DeviceNeedsSupplies($this->device->getIdentity(), $this->device->getReport());
		}
		
	}
	
	public function getEvents()
	{
		if (empty($this->events)) {
			return array(new Events\DeviceIsOk($this->device->getIdentity()));
		}
		return $this->events;
	}
}

?>