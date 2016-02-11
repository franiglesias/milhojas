<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\EventStream;
/**
* A simple in memory event storage.
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
	
	public function loadStream(EntityData $entity) 
	{
		$events = $this->events[$entity->getType()][$entity->getId()];
		return new EventStream($events);
	}
	
	public function saveStream(EntityData $entity, EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->events[$entity->getType()][$entity->getId()][] = $message;
		}
	}
	
	public function count(EntityData $entity)
	{
		return count($this->events[$entity->getType()][$entity->getId()]);
	}
}

?>