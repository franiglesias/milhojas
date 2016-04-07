<?php

namespace Milhojas\Library\EventBus;

interface EventStreamInterface extends \IteratorAggregate {
	public function getIterator();
	public function recordThat($event);
	public function flush();
	public function count();
}

?>