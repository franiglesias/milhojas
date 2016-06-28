<?php

namespace  Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\EventSourcingStorageInterface;

use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventSourcing\EventStore\EventStore;
use Milhojas\Library\EventSourcing\DTO\EntityDTO;

/**
 * A EventSourcing based Storage. Accepts and returns objects using a EventStore to save and retrieve event streams
 * 
 * It assumes that Entities has a reconstitute static method
 *
 * @package default
 * @author Fran Iglesias
 */

class EventSourcingStorage implements EventSourcingStorageInterface
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
		if (!$this->entityType) {
			throw new \InvalidArgumentException('EntityType not defined for EventSourcingStorage. Repository should set Storage->setEntityType(Entity)');
		}

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