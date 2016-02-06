<?php

namespace Milhojas\Library\EventSourcing;

use Rhumsaa\Uuid\Uuid;
/**
* Stores an event and metadata needed
*/
class EventMessage
{
	private $id;
	private $event;
	private $payload;
	private $time;
	private $version;
	private $entity_type;
	private $entity_id;
	private $metadata;
	
	function __construct()
	{
		$this->id = $this->getIdentity();
		$this->time = time();
		$this->metadata = array();
	}
	
	static public function record(DomainEvent $event, $entity_type, $entity_id)
	{
		$Message = new static();
		$Message->entity_type = $entity_type;
		$Message->entity_id = $entity_id;
		$Message->event = get_class($event);
		$Message->payload = $event;
		return $Message;
	}
	
	private function getIdentity()
	{
		$uuid = Uuid::uuid4();
		return $uuid->toString();
	}
	
	public function getEvent()
	{
		return $this->payload;
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
	
}

?>