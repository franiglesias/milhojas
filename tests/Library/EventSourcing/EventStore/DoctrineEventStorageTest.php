<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\DoctrineEventStorage;
use Milhojas\Library\EventSourcing\EventStore\EntityData;
use Milhojas\Library\EventSourcing\EventStore\EventDTO;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class DoctrineEventStorageTest extends \PHPUnit_Framework_TestCase
{
	private function getRepository()
	{
		$postRepository = $this
			->getMockBuilder('Doctrine\ORM\EntityRepository')
			->disableOriginalConstructor()
			->getMock();
		return $postRepository;
	}

	private function getEntityManager()
	{
		$entityManager = $this
			->getMockBuilder('Doctrine\ORM\EntityManager')
			->disableOriginalConstructor()
			->getMock();
		return $entityManager;
	}

	private function getEvent($name, $entity)
	{
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName($name)
			->disableOriginalConstructor()
			->getMock();
		return EventMessage::record($Event, $entity);
	}

	private function getEntity($id = 1)
	{
		$entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\EventSourced')
			->getMock();
		return $entity;
	}
	
	private function getStreamForEntity($entity)
	{
		return new EventStream(array(
			$this->getEvent('EntityCreated', $entity),
			$this->getEvent('EntityUpdated', $entity),
			$this->getEvent('EntityDeleted', $entity)
		));
	}
	
	public function test_it_can_store_an_event_strem_for_an_entity()
	{
		$em = $this->getEntityManager();
		$em->expects($this->exactly(3))
			->method('persist');
		
		$Stream = $this->getStreamForEntity($this->getEntity(1));

		$Storage = new DoctrineEventStorage($em);
		$Storage->saveStream( new EntityData('Entity', '1', 2), $Stream);
		
	}
	
	public function test_it_can_store_an_event_stream_for_different_entities()
	{
		$em = $this->getEntityManager();
		$em->expects($this->exactly(6))
			->method('persist');
		
		$Stream = $this->getStreamForEntity($this->getEntity(1));
		$Stream2 = $this->getStreamForEntity($this->getEntity(2));
		
		$Storage = new DoctrineEventStorage($em);
		$Storage->saveStream( new EntityData('Entity', 1, 2), $Stream);
		$Storage->saveStream( new EntityData('Entity', 2, 2), $Stream2);
	}

	public function test_it_can_load_an_event_stream_for_an_entity()
	{
		$em = $this->getEntityManager();
		
		$Stream = $this->getStreamForEntity($this->getEntity(1));
		$Stream2 = $this->getStreamForEntity($this->getEntity(2));
		
		$em->expects($this->exactly(6))
			->method('persist');
		
		$Storage = new DoctrineEventStorage($em);
		$Storage->saveStream( new EntityData('Entity', 1, 2), $Stream);
		$Storage->saveStream( new EntityData('Entity', 2, 2), $Stream2);
		
		$entity = $this->getEntity(1);
		$events = array(
			$this->getEvent('EntityCreated', $entity),
			$this->getEvent('EntityUpdated', $entity),
			$this->getEvent('EntityDeleted', $entity)
		);
		
		$dtos = array();
		foreach ($events as $event) {
			$dtos[] = EventDTO::fromEventMessage($event);
		}
		
		$repo = $this->getRepository();

		$repo->expects($this->once())
			->method('findBy')
			->will($this->returnValue($dtos));
		
		$em->expects($this->once())
			->method('getRepository')
			->will($this->returnValue($repo));
		$loadedStream = $Storage->loadStream(new EntityData('Entity', 1, 2));
		
		$this->assertEquals($Stream, $loadedStream);
	}

	public function test_it_counts_events_for_an_entity()
	{
	
	}
}

?>