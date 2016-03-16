<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;

class EventRecorder implements \IteratorAggregate
{
	
	private $events;
	
	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}
	
	public function recordThat(Event $event)
	{
		$this->events[] = $event;
	}
	
	public function retrieve()
	{
		return $this->events;
	}
}
?>