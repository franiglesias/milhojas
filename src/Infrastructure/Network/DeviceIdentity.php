<?php

namespace Milhojas\Infrastructure\Network;

/**
* Description
*/
class DeviceIdentity
{
	protected $name;
	protected $location;
	
	function __construct($name, $location)
	{
		$this->name = $name;
		$this->location = $location;
	}
	
}

?>