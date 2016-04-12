<?php

namespace Tests\Infrastructure\Persistence\Storage\Doubles;

/**
* A simple object to use in tests
*/
class StoreObject
{
	private $value;
	
	function __construct($value)
	{
		$this->value = $value;
	}
	
	public function getValue()
	{
		return $this->value;
	}
}

?>