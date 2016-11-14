<?php

namespace Milhojas\Library\EventSourcing\Domain;

use Milhojas\Library\EventBus\Event;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\EventSourcing\DTO\EntityDTO;
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
		$entity->initStream(true);
		return $entity;
	}
	
	/**
	 * Returns the stream of recorded events
	 *
	 * @return EventStream
	 */
	public function getEvents()
	{
		$this->initStream();
		return $this->events;
	}
	
	public function retrieveEvents()
	{
		$this->initStream();
		$events = [];
		foreach ($this->events as $message) {
			$events[] = $message->getEvent();
		}
		return $events;
	}
	
	/**
	 * Clears the stored list of events
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function clearEvents()
	{
		$this->initStream();
		$this->events->flush();
	}
	
	/**
	 * Apply an Event to the Entity
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
		$this->initStream();
		$this->events->recordThat(EventMessage::record($event, EntityDTO::fromEntity($this)));
	}
	
	protected function initStream($force = false)
	{
		if (!$this->events || $force) {
			$this->events = new EventStream();
		}
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
