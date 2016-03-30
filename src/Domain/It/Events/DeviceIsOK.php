<?php

namespace Milhojas\Domain\It\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\It\DeviceIdentity;
/**
* Description
*/
class DeviceIsOK implements Event
{
	private $device;
	
	function __construct(DeviceIdentity $device)
	{
		$this->device = $device;
	}
	
	public function getDevice()
	{
		return $this->device;
	}
	
	public function getDetails()
	{
		return '';
	}
	
	public function getName()
	{
		return 'milhojas.it.device_is_ok';
	}
}

?>