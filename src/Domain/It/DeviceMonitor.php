<?php

namespace Milhojas\Domain\It;

use Milhojas\Domain\It\Device;
use Milhojas\Domain\It\Events as Events;

/**
* Polls the Device for state and generate events according
*/
class DeviceMonitor
{
	private $events;
	private $device;
	
	public function poll(Device $device)
	{
		$this->device = $device;
		$this->checkIfDeviceWentDown();
		$this->checkIfDeviceStoppedListening();
		$this->checkIfDeviceFailed();
		$this->checkIfDeviceRanOutOfSupplies();
	}

	private function checkIfDeviceWentDown()
	{
		if (! $this->device->isUp()) {
			$this->events[] = new Events\DeviceWentDown($this->device->getIdentity(), $this->device->getReport());
		}
	}
	
	private function checkIfDeviceStoppedListening()
	{
		if (! $this->device->isListening()) {
			$this->events[] = new Events\DeviceStoppedListening($this->device->getIdentity(), $this->device->getReport());
		}
	}
	
	private function checkIfDeviceFailed()
	{
		if ($this->device->needsService()) {
			$this->events[] = new Events\DeviceFailed($this->device->getIdentity(), $this->device->getReport());
		}
	}
	
	public function checkIfDeviceRanOutOfSupplies()
	{
		if ($this->device->needsSupplies()) {
			$this->events[] = new Events\DeviceRanOutOfSupplies($this->device->getIdentity(), $this->device->getReport());
		}
	}
	
	public function getEvents()
	{
		if (empty($this->events)) {
			return array(new Events\DeviceWasOk($this->device->getIdentity()));
		}
		return $this->events;
	}
}

?>