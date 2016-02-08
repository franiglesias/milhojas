<?php

namespace Milhojas\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventSourced;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;
/**
* Base class for Event Sourced Domain Entities. EventSourced Enttities should extend this class
*/
abstract class EventSourcedEntity implements EventSourced
{
	protected $events;
	
	abstract public function getEntityId();
	/**
	 * Returns a instance of the Entity from a stream of events
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
		return new EventStream((array)$this->events);
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
		$this->handle($event);
	}
	
	protected function handle($event)
	{
		$method = $this->getMethod($event);
		if (! method_exists($this, $method)) {
			return;
		}
		$this->$method($event);
		$this->record($event);
	}
	protected function record($event)
	{
		$this->events[] = EventMessage::record($event, $this);
	}
	protected function getMethod($event)
	{
		$parts = explode('\\', get_class($event));
		return 'apply'.end($parts);
		
	}
}


?>