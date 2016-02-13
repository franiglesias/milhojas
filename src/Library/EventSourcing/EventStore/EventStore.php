<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\DTO\EntityData;

/**
 * An event storage stores event streams and allow us to recover the full stream for an entity.
 * Use an event based storage in repositories to create event based ones
 *
 * @package default
 */
interface EventStore {
	public function loadStream(EntityData $entity);
	public function saveStream(EventStream $stream);
}

?>