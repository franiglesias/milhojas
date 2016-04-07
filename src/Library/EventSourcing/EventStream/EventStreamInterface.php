<?php

namespace Milhojas\Library\EventSourcing\EventStream;

use Milhojas\Library\EventSourcing\EventStream\Recordable;

interface EventStreamInterface extends \IteratorAggregate {
	public function getIterator();
	public function recordThat(Recordable $event);
	public function flush();
	public function count();
}

?>