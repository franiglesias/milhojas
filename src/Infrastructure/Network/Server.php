<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Domain\It\Device;
/**
* Represents a simple server
*/
class Server implements Device
{
	private $device;
	private $status;
	private $messages;

	
	function __construct(DeviceIdentity $device, DeviceStatus $status)
	{
		$this->device = $device;
		$this->status = $status;
	}
	
	public function isUp()
	{
		return $this->status->isUp();
	}
	
	public function isListening()
	{
		return $this->status->isListening();
	}
		
	public function needsSupplies()
	{
		return false;
	}
	
	public function needsService()
	{
		return (! $this->isUp() || ! $this->isListening() );
	}
	
	public function getReport()
	{
		return implode(chr(10), $this->messages);
	}
	public function getIdentity()
	{
		return $this->device;
	}
	
	protected function recordThat($message)
	{
		$this->messages[] = $message;
	}
	
}


?>