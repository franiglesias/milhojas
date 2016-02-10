<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;
use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\EventStore\EntityDTO;
use Doctrine\ORM\Entitymanager;

class DoctrineEventStorage implements EventStorage
{
	private $em;
	
	function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function loadStream(EntityDTO $entity) 
	{
		$events = array();
		return new EventStream($events);
	}
	
	public function saveStream(EntityDTO $entity, EventStream $stream)
	{
		foreach ($stream as $message) {
			$event = $this->buildEvent($message);
			$this->em->persist($event);
		}
		$this->em->flush();
		$this->em->clear();
	}
	
	public function buildEvent(EventMessage $message)
	{
		$event = new Event();
		$event->setId($message->getEnvelope()->getId());
		$event->setEvent($message->getEvent());
		$event->setEventType($message->getEnvelope()->getEventType());
		$event->setEntityType($message->getEnvelope()->getEntityType());
		$event->setEntityId($message->getEnvelope()->getEntityId());
		$event->setVersion($message->getEnvelope()->getVersion());
		$event->setMetadata($message->getEnvelope()->getMetadata());
		$event->setTime($message->getEnvelope()->getTime());
		return $event;
	}
}


?>