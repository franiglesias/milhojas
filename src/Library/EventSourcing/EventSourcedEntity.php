<?php

namespace Milhojas\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventSourced;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;
/**
* Base class for Event Sourced Domain Entities
*/
abstract class EventSourcedEntity implements EventSourced
{
	protected $events;
	
	abstract public function getEntityId();
	
	public function getEvents()
	{
		return $events;
	}
	
	public function reconstitute(EventStream $stream)
	{
		# code...
	}
	
	public function apply(DomainEvent $event)
	{
		$this->handle($event);
		// Create e EventMessage and store in events
		$this->events[] = EventMessage::record($event, get_class($this), $this->getEntityId());
	}
	
	protected function handle($event)
	{
		$method = $this->getMethod($event);
		if (! method_exists($this, $method)) {
			return;
		}
		$this->$method($event);
	}
	protected function getMethod($event)
	{
		$parts = explode('\\', get_class($event));
		return 'apply'.end($parts);
		
	}
}


?>