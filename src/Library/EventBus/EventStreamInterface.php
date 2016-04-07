<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Recordable;

interface EventStreamInterface extends \IteratorAggregate {
	public function getIterator();
	public function recordThat(Recordable $event);
	public function flush();
	public function count();
}

?>