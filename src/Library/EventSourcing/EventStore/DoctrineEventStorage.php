<?php

namespace Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;

use Milhojas\Library\EventSourcing\EventStore\EventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\DTO\EventDAO;

use Milhojas\Library\EventSourcing\Exceptions as Exception;

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
            ->getRepository('EventStore:EventDAO')
			->findBy(array(
				'entity_type' => $entity->getType(),
				'entity_id' => $entity->getId()
			));
		if (!$dtos) {
			throw new Exception\EntityNotFound(sprintf('No events found for entity: %s', $entity->getType()), 2);
		}
		$stream = new EventStream();
		foreach ($dtos as $dto) {
			$stream->append(EventMessage::fromDTO($dto));
		}
		return $stream;
	}
	
	public function saveStream(EventStream $stream)
	{
		foreach ($stream as $message) {
			$this->checkVersion($message->getEntity());
			$this->em->persist(EventDAO::fromEventMessage($message));
		}
		$this->em->flush();
		$this->em->clear();
	}
	
	public function count(EntityData $entity)
	{
		return $this->em
			->createQuery('SELECT COUNT(events.id) FROM EventStore:EventDAO events WHERE events.entity_type = :entity AND events.entity_id = :id')
			->setParameter('entity', $entity->getType())
			->setParameter('id', $entity->getId())
			->getSingleScalarResult();
	}
	
	protected function getStoredVersion($entity)
	{
		return $this->em
			->createQuery('SELECT MAX(events.version) FROM EventStore:EventDAO events WHERE events.entity_type = :entity AND events.entity_id = :id')
			->setParameter('entity', $entity->getType())
			->setParameter('id', $entity->getId())
			->getSingleScalarResult();
	}
	
	protected function checkVersion($entity)
	{
		$newVersion = $entity->getVersion();
		$storedVersion = $this->getStoredVersion($entity);
		if ($newVersion <= $storedVersion) {
			throw new Exception\ConflictingVersion(sprintf('Stored version found to be %s, trying to save version %s', $storedVersion, $newVersion), 1);
		}
	}


}


?>