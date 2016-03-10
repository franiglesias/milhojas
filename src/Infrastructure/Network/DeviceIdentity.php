<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;


use Milhojas\Library\System\Ping;


/**
* Description
*/
class Device
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
	
	public function isUp()
	{
		return $this->ip->isUp();
	}
}

?>