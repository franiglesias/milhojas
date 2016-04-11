<?php

namespace Milhojas\Library\EventSourcing\EventStream;

use Milhojas\Library\EventSourcing\EventStream\Recordable;

interface EventStreamInterface extends \IteratorAggregate {
	public function getIterator();
	
	/**
	 * Adds a Recordable event to the stream
	 *
	 * @param Recordable $event 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function recordThat(Recordable $event);
	
	/**
	 * Empties the stream
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function flush();
	
	/**
	 * Return the number of recorded events
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function count();
	
	/**
	 * Load an array of events to the stream without extra processing
	 * Use to pass a batch of verified events to the stream
	 *
	 * @param array $events 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function load(array $events);
}

?>