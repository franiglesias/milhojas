<?php

namespace Milhojas\Library\EventSourcing\EventStream;

use Milhojas\Library\EventSourcing\EventStream\EventMessage;
// use Milhojas\Library\EventSourcing\EventStream\Recordable;

use Milhojas\Library\EventSourcing\DTO\EntityDTO;

/**
 * Keeps a list of event messages. 
 * 
 * An even message contains Event object and metadata
 * EventSourced Entities return an EventStream
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class EventStream implements \IteratorAggregate {
	
	private $events;
	
	public function __construct()
	{
		$this->events = array();
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->events);
	}
	
	public function count()
	{
		return count($this->events);
	}
	
	public function load(array $events)
	{
		foreach ($events as $event) {
			$this->append($event);
		}
	}
	
	private function append(EventMessage $event)
	{
		$this->events[] = $event;
	}
	
	public function flush()
	{
		$this->events = array();
	}

	public function recordThat(EventMessage $event)
	{
		$this->events[] = $event;
	}
	
	public function __toString()
	{
		$buffer[] = sprintf('Stream has %s events', count($this->events));
		$counter = 0;
		foreach ($this->events as $event) {
			$buffer[] = sprintf('[%s] %s', $counter, $event);
			$counter++;
		}
		return implode(chr(10), $buffer);
	}
}

?>