<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventSourced;
/**
* Transports information about entity type and id
*/
class EntityDTO
{
	private $type;
	private $id;
	
	function __construct($type, $id)
	{
		$this->type = $type;
		$this->id = $id;
	}
	
	static public function fromEntity(EventSourced $entity)
	{
		return new static(get_class($entity), $entity->getEntityId());
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
}
?>