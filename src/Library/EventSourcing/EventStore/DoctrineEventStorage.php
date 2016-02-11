<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;
use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\EventStore\EntityData;
use Doctrine\ORM\Entitymanager;

class DoctrineEventStorage implements EventStorage
{
	private $em;
	
	function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function loadStream(EntityData $entity) 
	{
		$events = $this->em
            ->getRepository('EventStore:EventDTO')
			->findBy(array(
				'entity_type' => $entity->getType(),
				'entity_id' => $entity->getId()
			));
		foreach ($events as $event) {
			# code...
		}
		return new EventStream($events);
	}
	
	public function saveStream(EntityData $entity, EventStream $stream)
	{
		foreach ($stream as $message) {
			$event = $this->buildEvent($message);
			$this->em->persist($event);
		}
		$this->em->flush();
		$this->em->clear();
	}
	
	private function buildEvent(EventMessage $message)
	{
		$event = new EventDTO();
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