<?php

namespace Tests\Library\EventSourcing\EventStore\Fixtures;

use Milhojas\Library\EventSourcing\Domain\Event;

/**
* Description
*/
class EventDouble implements Event
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return 'event_double';
	}
}


?>