<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;

/**
 * Records plain events to store them temporary and pass them later to an Event Dispatcher
 *
 * @package milhojas.library.eventbus
 * @author Fran Iglesias
 */

class EventRecorder implements \IteratorAggregate
{
	/**
	 * Array of stored events
	 */
	private $events = array();
	
	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}
	
	/**
	 * Records an Event, appending it to the stored ones
	 */
	public function recordThat(Event $event)
	{
		$this->events[] = $event;
	}
	
	/**
	 * Records an array of events
	 */
	public function load(array $events)
	{
		foreach ($events as $event) {
			$this->recordThat($event);
		}
	}
	
	/**
	 * Retrieves a plain array of events
	 */
	public function retrieve()
	{
		return $this->events;
	}
	
	/**
	 * Empties the array of events. Use after currents events are dispatched
	 */
	public function flush()
	{
		$this->events = array();
	}
	
	/**
	 * Counts the events stored in the Recorder
	 */	
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