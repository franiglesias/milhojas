<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;

interface EventSourcingStorageInterface extends StorageInterface{
	public function setEntityType($entity_type);
}

?>