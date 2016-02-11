<?php

namespace Milhojas\Library\EventSourcing;

/**
 * Keeps a list of event messages
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class EventStream implements \IteratorAggregate {
	
	private $events;
	
	public function __construct(array $events = array())
	{
		$this->events = $events;
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}
	
	public function count()
	{
		return count($this->events);
	}
	
	public function flush()
	{
		$this->events = array();
	}
	
	public function append($event)
	{
		$this->events[] = $event;
	}
}

?>