<?php

namespace Milhojas\Library\EventSourcing\DTO;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
/**
* Transports information about an individual entity
*/
class EntityData
{
	protected $type;
	protected $id;
	
	function __construct($type, $id)
	{
		$this->type = $type;
		$this->id = $id;
	}
	
	static public function fromEntity(EventSourced $entity)
	{
		return new static(get_class($entity), $entity->getEntityId());
	}
	
	static public function fromDTO($dto)
	{
		return new static($dto->getEntityType(), $dto->getEntityId());
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	
	public function __toString()
	{
		return sprintf('Entity: %s::%s', $this->type, $this->id);
	}
}
?>