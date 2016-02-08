<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventSourced;
/**
* Description
*/
class EntityDTO
{
	private $type;
	private $id;
	
	function __construct(EventSourced $entity)
	{
		$this->type = get_class($entity);
		$this->id = $entity->getEntityId();
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