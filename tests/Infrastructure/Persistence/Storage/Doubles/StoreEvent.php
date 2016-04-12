<?php

namespace Tests\Infrastructure\Persistence\Storage\Doubles;

use Milhojas\Library\EventSourcing\Domain\Event;

class StoreEvent implements Event
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
	
	public function getName()
	{
		return 'test.store_event';
	}
}

?>