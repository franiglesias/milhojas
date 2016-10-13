<?php

namespace Milhojas\Domain\It;

/**
* Value Object that describes the identity of a device for users
*/
class DeviceIdentity
{
	protected $name;
	protected $location;
public function __construct($name, $location)
	{
		$this->name = $name;
		$this->location = $location;
	}
	
	public function __toString()
	{
		return sprintf('%s at %s', $this->name, $this->location);
	}
	
}

?>
