<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\DTO\EntityData;

interface EventBasedStorageDriver {
	public function loadStream(EntityData $entity);
	public function saveStream(EventStream $stream);
}

?>