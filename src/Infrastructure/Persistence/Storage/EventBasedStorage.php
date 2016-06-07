<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;

use Milhojas\Infrastructure\Persistence\Storage\Drivers\StorageDriver;
use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventSourcing\DTO\EventDTO;
use Milhojas\Library\EventSourcing\DTO\EntityVersionData;
use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\EventStream\EventMessage;

class EventBasedStorage implements StorageInterface
{
	private $driver;
	private $entityType;
	
	function __construct(StorageDriver $driver, $entity_type)
	{
		$this->driver = $driver;
		$this->entityType = $entity_type;
	}
	
	public function load(Id $id)
	{
		$entity = new EntityVersionData($this->entityType, $id);
		$dtos = $this->driver->findAll($entity->getKey());
		$stream = $this->buildStream($dtos);
		return forward_static_call_array(array($this->entityType, 'reconstitute'), array($stream));
	}

	private function buildStream($dtos)
	{
		if (empty($dtos)) {
			throw new \OutOfBoundsException("No data found", 1);
		}
		$stream = new EventStream();
		foreach ($dtos as $dto) {
		 	$stream->recordThat(EventMessage::fromDTO($dto));
		}
		return $stream;
	}
	
	public function store($object)
	{
		foreach ($object->getEvents() as $message) {
			$this->driver->save(EventDTO::fromEventMessage($message));
		}
		print_R($this->driver);
	}
	public function delete(Id $id)
	{
		$entity = new EntityVersionData($this->entityType, $id);
		$dtos = $this->driver->findAll($entity->getKey());
		if (empty($dtos)) {
			throw new \OutOfBoundsException("No data found", 1);
		}
		foreach ($dtos as $key => $dto) {
			$this->driver->delete($dto);
		}
	}
	
}

?>