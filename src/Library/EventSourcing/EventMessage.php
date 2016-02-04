<?php

namespace Milhojas\Library\EventSourcing;

use Rhumsaa\Uuid\Uuid;
/**
* Description
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
		$this->id = $this->createEventId();
		$this->time = time();
	}
	
	static public function record($event, $entity_type, $entity_id)
	{
		$Message = new static();
		$Message->entity_type = $entity_type;
		$Message->entity_id = $entity_id;
		$Message->event = get_class($event);
		$Message->payload = $event;
		return $Message;
	}
	
	private function createEventId()
	{
		$uuid = Uuid::uuid4();
		return $uuid->toString();
	}
	
	public function getEvent()
	{
		return $this->payload;
	}
	
	
}

?>