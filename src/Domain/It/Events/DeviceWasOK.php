<?php

namespace Milhojas\Domain\It\Events;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Domain\It\DeviceIdentity;
/**
* Description
*/
class DeviceWasOK implements Event
{
	private $device;
	private $details;
	
	function __construct(DeviceIdentity $device, $details)
	{
		$this->device = $device;
		$this->details = $details;
	}
	
	public function getDevice()
	{
		return $this->device;
	}
	
	public function getDetails()
	{
		return $this->details;
	}
	
	public function getName()
	{
		return 'milhojas.it.device_was_ok';
	}
}

?>