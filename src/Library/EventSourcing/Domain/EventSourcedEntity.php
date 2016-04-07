<?php

namespace Milhojas\Library\EventSourcing\Domain;

use Milhojas\Library\EventSourcing\Domain\EventSourced;

use Milhojas\Library\EventSourcing\Domain\Event;

use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\DTO\EntityVersionData;

use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\EventStream\EventMessage;

/**
* Base class for Event Sourced Domain Entities. 
* EventSourced Enttities should extend this class
*/
abstract class EventSourcedEntity implements EventSourced
{
	protected $events = array();
	protected $version = 0;
	
	abstract public function getId();
	
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
	 * Clears the stored list of events
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function clearEvents()
	{
		$this->events = array();
	}
	
	/**
	 * Apply a Event to the Entity
	 *
	 * @param Event $event 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	public function apply(Event $event)
	{
		$method = $this->getMethod($event);
		$this->$method($event);
		$this->version++;
	}
	
	/**
	 * Apply and record an event
	 *
	 * @param Event $event 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	protected function recordThat(Event $event)
	{
		if (!$this->canHandleEvent($event)) {
			return;
		}
		$this->apply($event);
		$this->events[] = EventMessage::record($event, EntityVersionData::fromEntity($this));
	}

	public function getVersion()
	{
		return $this->version;
	}
	
	protected function getMethod($event)
	{
		$parts = explode('\\', get_class($event));
		return 'apply'.end($parts);
	}
	
	protected function canHandleEvent(Event $event)
	{
		return method_exists($this, $this->getMethod($event));
	}
	

}


?>