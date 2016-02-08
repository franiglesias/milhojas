<?php

namespace Milhojas\Library\EventSourcing;

use Rhumsaa\Uuid\Uuid;
use Milhojas\Library\EventSourcing\EventStore\EntityDTO;
/**
* Description
*/
class EventMessageEnvelope
{
	private $id;
	private $event_type;
	private $time;
	private $version;
	private $entity;
	private $metadata;
	
	function __construct(DomainEvent $event, EventSourced $entity)
	{
		$this->id = $this->assignIdentity();
		$this->time = time();
		$this->metadata = array();
		$this->getEntityData($entity);
		$this->event_type = get_class($event);
		$this->entity = new EntityDTO($entity);
	}
	
	
	private function getEntityData($entity)
	{
		$this->entity_type = get_class($entity);
		$this->entity_id = $entity->getEntityId();
	}
	
	private function assignIdentity()
	{
		$uuid = Uuid::uuid4();
		return $uuid->toString();
	}
	
	public function addMetaData($key, $value = null)
	{
		$data = $key;
		if (!is_array($key)) {
			$data = array($key => $value);
		}
		$this->metadata += $data;
	}
	
	public function getMetaData()
	{
		return $this->metadata;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getTime()
	{
		return $this->time;
	}
	public function getEntityType()
	{
		return $this->entity->getType();
	}
	public function getEntityId()
	{
		return $this->entity->getId();
	}
	
}

?>