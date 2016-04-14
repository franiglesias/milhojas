<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\Exceptions as Exception;

/**
* A simple in memory event storage.
*/
class InMemoryEventStorage extends EventStorage
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
			throw new Exception\EntityNotFound(sprintf('No events found for entity: %s', $entity->getType()), 2);
		}
		$events = $this->events[$entity->getType()][$entity->getPlainId()];
		$stream = new EventStream();
		$stream->load($events);
		return $stream;
	}
	
	public function saveStream(EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->checkVersion($message->getEntity());
			$this->events[$message->getEntity()->getType()][$message->getEntity()->getPlainId()][] = $message;
		}
	}

	public function count(EntityData $entity)
	{
		if ($this->thereAreEventsForEntity($entity)) {
			return count($this->events[$entity->getType()][$entity->getPlainId()]);
		}
		return 0;
	}
	
	public function countEntitiesOfType($type)
	{
		if (isset($this->events[$type])) {
			return count($this->events[$type]);
		}
		return 0;
	}

	protected function thereAreEventsForEntity($entity)
	{
		return isset($this->events[$entity->getType()][$entity->getPlainId()]);
	}

	protected function getStoredVersion(EntityData $entity)
	{
		return $this->count($entity);
	}
	
	public function getEvents()
	{
		return $this->events;
	}
	
}

?>