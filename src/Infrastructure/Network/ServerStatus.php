<?php

namespace Milhojas\Infrastructure\Network;

use  Milhojas\Library\ValueObjects\Technical\Ip;
use  Milhojas\Domain\It\DeviceStatus;

/**
* Retrieves information from a device connected to the net
*/
class ServerStatus implements DeviceStatus
{
	private $ip;
	
	public function __construct(Ip $ip)
	{
		$this->ip = $ip;
	}
	
	public function isUp()
	{
		return $this->ip->isUp();
	}
	
	public function isListening()
	{
		return $this->ip->isListening();
	}
	
	public function updateStatus($force = false)
	{
		return false;
	}
	
	public function getIp()
	{
		return $this->ip;
	}
}

?>
