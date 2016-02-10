<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;

/**
 * An event storage stores event streams and allow us to recover the full stream for an entity
 *
 * @package default
 */
interface EventStorage {
	public function loadStream(EntityDTO $entity);
	public function saveStream(EntityDTO $entity, EventStream $stream);
}

?>