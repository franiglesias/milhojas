<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;

interface EventSourcingStorageInterface extends StorageInterface{
	public function setEntityType($entity_type);
}

?>