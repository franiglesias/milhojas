<?php

namespace Milhojas\Library\EventSourcing\Domain;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\EventSourcing\Domain\DomainEvent;
use Milhojas\Library\EventSourcing\DTO\EntityData;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;

/**
* Base class for Event Sourced Domain Entities. 
* EventSourced Enttities should extend this class
*/
abstract class EventSourcedEntity implements EventSourced
{
	protected $events = array();
	protected $version = -1;
	
	abstract public function getEntityId();
	
	/**
	 * Recreates an instance of the Entity from a stream of events
	 *
	 * @param EventStream $stream 
	 * @return EventSourcedEntity
	 */
	static public function reconstitute(EventStream $stream)
	{
		$entity = new static();
		foreach ($stream as $message) {
			$entity->apply($message->getEvent());
		}
		return $entity;
	}
	
	/**
	 * Returns the stream of recorded events
	 *
	 * @return EventStream
	 */
	public function getEvents()
	{
		return new EventStream($this->events);
	}
	
	/**
	 * Apply a DomainEvent to the Entity and appends it to the Event Stream
	 *
	 * @param DomainEvent $event 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	public function apply(DomainEvent $event)
	{
		$method = $this->getMethod($event);
		$this->$method($event);
		$this->version++;
	}
	
	public function getVersion()
	{
		return $this->version;
	}
	
	protected function recordThat(DomainEvent $event)
	{
		if (!$this->canHandleEvent($event)) {
			return;
		}
		$this->events[] = EventMessage::record($event, EntityData::fromEntity($this));
		$this->apply($event);
	}
	
	protected function getMethod($event)
	{
		$parts = explode('\\', get_class($event));
		return 'apply'.end($parts);
	}
	
	protected function canHandleEvent(DomainEvent $event)
	{
		return method_exists($this, $this->getMethod($event));
	}
	

}


?>