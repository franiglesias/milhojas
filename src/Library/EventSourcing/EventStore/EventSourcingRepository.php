<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventSourcing\EventStore\EventStorage;

class EventSourcingRepository implements StorageInterface
{
	private $store;
	private $entityType;

	public function __construct(EventStorage $store, $entity_type)
	{
		$this->store = $store;
		$this->entityType = $entity_type;
	}
	public function load(Id $id)
	{
		# code...
	}
	
	public function store($object)
	{
		# code...
	}
	
	public function delete($object)
	{
		# code...
	}
}

?>