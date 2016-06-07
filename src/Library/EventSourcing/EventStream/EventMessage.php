<?php

namespace Milhojas\Library\EventSourcing\EventStream;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventSourcing\EventStream\Recordable;
use Milhojas\Library\EventSourcing\Domain\EventSourced;
use Milhojas\Library\EventSourcing\DTO\EntityDTO;


/**
* Stores an event and metadata needed
*/

class EventMessage implements Recordable
{
	private $event;
	private $envelope;
	private $entity;
	
	public function __construct(Event $event, EntityDTO $entity, EventEnvelope $envelope)
	{
		$this->event = $event;
		$this->entity = $entity;
		$this->envelope = $envelope;
	}
	
	static public function record(Event $event, EntityDTO $entity)
	{
		return new static(
			$event, 
			$entity,
			EventEnvelope::now()
		);
	}
	
	static public function fromDTO($dto)
	{
		return new static(
			$dto->getEvent(),
			EntityDTO::fromDTO($dto),
			EventEnvelope::fromDTO($dto)
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
	
	public function __toString()
	{
		return sprintf('%s with %s', get_class($this->event), $this->entity);
	}
	
	public function getId()
	{
		return $this->entity->getKey();
	}
	
}

?>