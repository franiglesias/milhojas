<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
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
		if (! $this->thereAreEventsForEntity($entity)) {
			throw new \UnderflowException("Error Processing Request", 1);
		}
		$events = $this->events[$entity->getType()][$entity->getId()];
		return new EventStream($events);
	}
	
	public function saveStream(EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->checkVersion($message->getEntity());
			$this->events[$message->getEntity()->getType()][$message->getEntity()->getId()][] = $message;
		}
	}
	
	public function count(EntityData $entity)
	{
		if ($this->thereAreEventsForEntity($entity)) {
			return count($this->events[$entity->getType()][$entity->getId()]);
		}
		return 0;
	}
	
	protected function thereAreEventsForEntity($entity)
	{
		return isset($this->events[$entity->getType()][$entity->getId()]);
	}
	
	protected function expectedVersion($entity)
	{
		return $this->count($entity) - 1;
	}
	
	protected function checkVersion($entity)
	{
		if ($entity->getVersion() < $this->expectedVersion($entity)) {
			throw new InvalidArgumentException("Error Processing Request", 1);
		}
	}
}

?>