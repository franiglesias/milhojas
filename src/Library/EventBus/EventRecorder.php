<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventStreamInterface;
use Milhojas\Library\EventBus\Recordable;

/**
 * Records plain events to store them temporary and pass them to an Event Dispatcher
 *
 * @package default
 * @author Fran Iglesias
 */

class EventRecorder implements EventStreamInterface
{
	
	private $events = array();
	
	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}
	
	public function recordThat(Recordable $event)
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
	
	public function flush()
	{
		$this->events = array();
	}
		
	public function count()
	{
		return count($this->events);
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