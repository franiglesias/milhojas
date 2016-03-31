<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;

/**
 * Records plain events to store them temporary and pass them to an Event Dispatcher
 *
 * @package default
 * @author Fran Iglesias
 */

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
	
	public function recordBatch(array $events)
	{
		foreach ($events as $event) {
			$this->recordThat($event);
		}
	}
	
	public function retrieve()
	{
		return $this->events;
	}
	
	public function forget()
	{
		$this->events = array();
	}
	
	public function __toString()
	{
		$string = '';
		foreach ($this->events as $event) {
			$string .= $event->getName().chr(10);
		}
		return $string;
	}
	
}
?>