<?php

namespace Milhojas\Library\EventSourcing\DTO;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\ValueObjects\Identity\Id;
/**
* Transports information about an individual entity
*/
class EntityData
{
	protected $type;
	protected $id;
	
	function __construct($type, Id $id)
	{
		$this->type = $type;
		$this->id = $id;
	}
	
	static public function fromEntity(EventSourced $entity)
	{
		return new static(get_class($entity), $entity->getId());
	}
	
	static public function fromDTO($dto)
	{
		return new static($dto->getEntityType(), $dto->getId());
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getPlainId()
	{
		return $this->id->getId();
	}
	
	
	public function __toString()
	{
		return sprintf('%s::%s', $this->type, $this->id->getId());
	}
}
?>