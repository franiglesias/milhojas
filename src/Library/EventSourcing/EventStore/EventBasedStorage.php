<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Infrastructure\Persistence\Common\StorageInterface;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\ValueObjects\Identity\Id;

/**
* Description
*/
class EventBasedStorage implements StorageInterface
{
	private $driver;
	private $entity;
	
	function __construct($entity, $driver)
	{
		$this->entity = $entity;
		$this->driver = $driver;
	}
	
	public function load(Id $id) 
	{
		$stream = $this->driver->loadStream(new EntityData($this->entity, $id));
		return forward_static_call_array(array('\\'.$this->entity, 'reconstitute'), array($stream));
	}
	public function store(Id $id, $object) 
	{
		
	}
	public function delete(Id $id) {}
	public function findAll() {}
	public function countAll() {}
}

?>