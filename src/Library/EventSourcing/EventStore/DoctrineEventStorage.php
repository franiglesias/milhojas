<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\DTO\EventDTO;

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
		$dtos = $this->em
            ->getRepository('EventStore:EventDTO')
			->findBy(array(
				'entity_type' => $entity->getType(),
				'entity_id' => $entity->getId()
			));
		$stream = new EventStream();
		foreach ($dtos as $dto) {
			$stream->append(EventMessage::fromDTO($dto));
		}
		return $stream;
	}
	
	public function saveStream(EntityData $entity, EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->em->persist(EventDTO::fromEventMessage($message));
		}
		$this->em->flush();
		$this->em->clear();
	}

}


?>