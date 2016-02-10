<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\EventStream;
/**
* 
*/
class InMemoryEventStorage implements EventStorage
{
	/**
	 * Store the events
	 *
	 * @var array
	 * $events[$entity][$entity_id] = foreach eventStream
	 */
	private $events;
	
	function __construct()
	{
		$this->events = array();
	}
	
	public function loadStream(EntityDTO $entity) 
	{
		$events = $this->events[$entity->getType()][$entity->getId()];
		return new EventStream($events);
	}
	
	public function saveStream(EntityDTO $entity, EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->events[$entity->getType()][$entity->getId()][] = $message;
		}
	}
	
	public function count(EntityDTO $entity)
	{
		return count($this->events[$entity->getType()][$entity->getId()]);
	}
}

?>