<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventSourcing\EventStore\EventStore;

use Milhojas\Library\EventSourcing\DTO\EntityDTO;

class EventSourcingStorage implements StorageInterface
{
	private $store;
	private $entityType;

	public function __construct(EventStore $store)
	{
		$this->store = $store;
	}
	
	public function setEntityType($entity_type)
	{
		$this->entityType = $entity_type;
	}
	
	public function load(Id $id, $version = null)
	{
		$stream = $this->store->loadStream($this->getEntity($id, $version));
		return call_user_func($this->entityType .'::reconstitute', $stream);
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