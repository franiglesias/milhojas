<?php

namespace Milhojas\Library\EventSourcing;
use Milhojas\Library\EventSourcing\EventStore\EntityData;
/**
* Stores an event and metadata needed
*/


class EventMessage
{
	private $event;
	private $envelope;
	private $entity;
	
	function __construct()
	{
	}
	
	static public function record(DomainEvent $event, EventSourced $entity)
	{
		$Message = new static();
		$Message->event = $event;
		$Message->envelope = EventMessageEnvelope::now();
		$Message->entity = EntityData::fromEntity($entity);
		return $Message;
	}
	
	static public function fromDTO($dto)
	{
		$Message = new static();
		$Message->event = $dto->getEvent();
		$Message->envelope = EventMessageEnvelope::fromDTO($dto);
		$Message->entity = EntityData::fromDTO($dto);
		return $Message;
	}
	
	public function getEvent()
	{
		return $this->event;
	}
	
	public function getEnvelope()
	{
		return $this->envelope;
	}
	
	public function getEntity()
	{
		return $this->entity;
	}
	
	public function addMetaData($key, $value = null)
	{
		$this->envelope->addMetaData($key, $value);
	}
	
	public function getMetaData()
	{
		return $this->envelope->getMetadata();
	}
	
}

?>