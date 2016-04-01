<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Domain\It\Device;
/**
* Provides some common behavior for devices
*/
abstract class BaseDevice implements Device
{
	protected $device;
	protected $status;
	protected $messages;
	
	public function isUp()
	{
		if (! $this->status->isUp()) {
			$this->recordThat(sprintf('%s is down', $this->device));
		}
		return $this->status->isUp();
	}
	
	public function isListening()
	{
		if (! $this->status->isListening()) {
			$this->recordThat('%s is not Listening at port %s', $this->device, $this->status->getIp()->getPort());
		}
		return $this->status->isListening();
	}
		
	abstract public function needsSupplies();
	
	abstract public function needsService();
	
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