<?php

namespace Milhojas\Library\EventSourcing\DTO;

use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\ValueObjects\Identity\Id;
/**
* Transports information about entity type, id, and version
*/
class EntityVersionData extends EntityData
{
	private $version;
	
	function __construct($type, Id $id, $version)
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
		
	public function getVersion()
	{
		return $this->version;
	}
	
	public function getKey($unique = false)
	{
		if (!$unique) {
			return parent::getKey();
		}
		return sprintf('%s:%s:%s', $this->type, $this->id->getId(), $this->version);
	}
	
}
?>