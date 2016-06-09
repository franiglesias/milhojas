<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventSourcing\EventStore\EventStorage;

// use Milhojas\Library\EventSourcing\EventStream\EventStream;
// use Milhojas\Library\EventSourcing\EventStream\EventMessage;
use Milhojas\Library\EventSourcing\DTO\EntityDTO;

class EventSourcingRepository implements StorageInterface
{
	private $store;
	private $entityType;

	public function __construct(EventStorage $store, $entity_type)
	{
		$this->store = $store;
		$this->entityType = $entity_type;
	}
	public function load(Id $id, $version = null)
	{
		$stream = $this->store->loadStream($this->getEntity($id, $version));
		$object = call_user_func($this->entityType .'::reconstitute', $stream);
		return $object;
	}
	
	private function getEntity(Id $id, $version)
	{
		if ($version) {
			return new EntityDTO($this->entityType, $id, $version);
		}
		return new EntityDTO($this->entityType, $id);
	}
	
	public function store($object)
	{
		$this->store->saveStream($object->getEvents());
		$object->clearEvents();
	}
	
	public function delete($object)
	{
		# code...
	}
}

?>