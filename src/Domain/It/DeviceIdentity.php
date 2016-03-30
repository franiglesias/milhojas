<?php

namespace Milhojas\Domain\It;

/**
* Value Object that describes the identity of a device for users
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