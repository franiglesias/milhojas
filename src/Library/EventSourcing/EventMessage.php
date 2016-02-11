<?php

namespace Milhojas\Library\EventSourcing;

use Milhojas\Library\EventSourcing\Domain\DomainEvent;
use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\EventSourcing\EventStore\EntityData;


/**
* Stores an event and metadata needed
*/


class EventMessage
{
	private $event;
	private $envelope;
	private $entity;
	
	private function __construct(DomainEvent $event, EntityData $entity, EventMessageEnvelope $envelope)
	{
		$this->event = $event;
		$this->entity = $entity;
		$this->envelope = $envelope;
	}
	
	static public function record(DomainEvent $event, EventSourced $entity)
	{
		return new static(
			$event, 
			EntityData::fromEntity($entity),
			EventMessageEnvelope::now()
		);
	}
	
	static public function fromDTO($dto)
	{
		return new static(
			$dto->getEvent(),
			EntityData::fromDTO($dto),
			EventMessageEnvelope::fromDTO($dto)
		);
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