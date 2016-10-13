<?php

namespace Tests\Library\EventSourcing\Fixtures;

use Milhojas\Library\EventBus\Event;

/**
* Description
*/
class ModificationEvent implements Event
{
	private $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
	public function getValue()
	{
		return $this->value;
	}
	
	public function getName()
	{
		return 'modification_event';
	}
}


?>
