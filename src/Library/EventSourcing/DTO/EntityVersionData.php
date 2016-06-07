<?php

namespace Milhojas\Library\EventSourcing\DTO;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\ValueObjects\Identity\Id;
/**
* Transports information about entity type, id, and version
*/
class EntityVersionData
{
	private $version;
	
	function __construct($type, Id $id, $version = 1)
	{
		$this->type = $type;
		$this->id = $id;
		$this->version = $version;
	}
	
	static public function fromEntity(EventSourced $entity)
	{
		return new static(get_class($entity), $entity->getId(), $entity->getVersion());
	}
	
	static public function fromDTO($dto)
	{
		return new static($dto->getEntityType(), new Id($dto->getEntityId()), $dto->getVersion());
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
			
	public function getVersion()
	{
		return $this->version;
	}
	
	public function getKey($unique = false)
	{
		if (!$unique) {
			return sprintf('%s:%s', $this->type, $this->id->getId());
		}
		return sprintf('%s:%s:%s', $this->type, $this->id->getId(), $this->version);
	}
	
	public function __toString()
	{
		return $this->getKey();
	}
}
?>