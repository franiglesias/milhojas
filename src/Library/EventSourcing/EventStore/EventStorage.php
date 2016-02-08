<?php

namespace Milhojas\Library\EventSourcing\EventStore;

/**
 * An event storage estores event streams and allow us to recover the full stream for an entity
 *
 * @package default
 */
interface EventStorage {
	public function loadStream(EntityDTO $entity, EventStram $stream);
	public function saveStream(EntityDTO $entity);
}

?>