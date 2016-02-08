<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;

/**
* 
*/
class InMemoryEventStorage implements EventStorage
{
	private $events;
	
	function __construct()
	{
		$this->events = array();
	}
	
	public function loadStream(EntityDTO $entity, EventStram $stream) 
	{
	}
	
	public function saveStream(EntityDTO $entity)
	{
		
	}
	
	public function count()
	{
		return count($this->events);
	}
}

?>