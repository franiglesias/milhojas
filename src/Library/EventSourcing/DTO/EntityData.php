<?php

namespace Milhojas\Library\EventSourcing\DTO;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
/**
* Transports information about entity type and id
*/
class EntityData
{
	private $type;
	private $id;
	private $version;
	
	function __construct($type, $id, $version)
	{
		$this->type = $type;
		$this->id = $id;
		$this->version = $version;
	}
	
	static public function fromEntity(EventSourced $entity)
	{
		return new static(get_class($entity), $entity->getEntityId(), $entity->getVersion());
	}
	
	static public function fromDTO($dto)
	{
		return new static($dto->getEntityType(), $dto->getEntityId(), $dto->getVersion());
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getVersion()
	{
		return $this->version;
	}
	
	public function __toString()
	{
		return sprintf('Entity: %s::%s (%s)', $this->type, $this->id, $this->version);
	}
}
?>