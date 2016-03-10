<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;

/**
* Description
*/
class DeviceIdentity
{
	protected $ip;
	protected $name;
	protected $location;
	protected $vendor;
	
	function __construct($name, $location, Ip $ip, Vendor $vendor)
	{
		$this->ip = $ip;
		$this->name = $name;
		$this->location = $location;
		$this->vendor = $vendor;
	}
	
	public function getIp()
	{
		return $this->ip->getIp();
	}
	
	public function isUp()
	{
		return $this->ip->isUp();
	}
	
	public function isListening()
	{
		return $this->ip->isListening();
	}
}

?>