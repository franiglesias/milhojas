<?php

namespace Milhojas\Library\EventSourcing\EventStream;

use Milhojas\Library\EventSourcing\EventStream\EventStreamInterface;
use Milhojas\Library\EventSourcing\EventStream\Recordable;

use Milhojas\Library\EventSourcing\DTO\EntityData;

/**
 * Keeps a list of event messages. 
 * 
 * An even message contains Event object and metadata
 * EventSourced Entities return an EventStream
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class EventStream implements EventStreamInterface {
	
	private $events;
	private $entity;
	
	public function __construct(EntityData $entity)
	{
		$this->entity = $entity;
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

	public function recordThat(Recordable $event)
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