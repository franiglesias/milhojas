<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Device;
use Milhojas\Infrastructure\Network\DeviceIdentitiy;
use Milhojas\Infrastructure\Network\Driver;
/**
* Description
*/
class BaseDevice implements Device
{
	protected $device;
	protected $driver;
	
	function __construct(DeviceIdentity $device, Driver $driver)
	{
		$this->device = $device;
		$this->driver = $driver;
	}
	
	public function isUp()
	{
		return $this->device->isUp();
	}
	
	public function isListening()
	{
		return $this->device->isListening();
	}
	
	public function needsService()
	{
		return $this->driver->needsService();
	}
	
	public function needsSupplies()
	{
		return $this->driver->needsSupplies();
	}
	
	public function getReport()
	{
		return $this->driver->getReport();
	}
	
}

?>