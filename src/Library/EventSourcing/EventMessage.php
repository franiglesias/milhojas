<?php

namespace Milhojas\Library\EventSourcing;


/**
* Stores an event and metadata needed
*/


class EventMessage
{
	private $event;
	private $envelope;
	
	function __construct()
	{
	}
	
	static public function record(DomainEvent $event, EventSourced $entity)
	{
		$Message = new static();
		$Message->event = $event;
		$Message->envelope = new EventMessageEnvelope($event, $entity);
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