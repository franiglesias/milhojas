<?php

namespace Milhojas\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventSourced;

/**
* Description
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