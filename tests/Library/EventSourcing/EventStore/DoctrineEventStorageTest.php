<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\DoctrineEventStorage;
use Milhojas\Library\EventSourcing\EventStore\EntityDTO;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class DoctrineEventStorageTest extends \PHPUnit_Framework_TestCase
{
	
	protected function getRepository()
	{
        $postRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
		return $postRepository;
	}
    protected function getEntityManager()
    {   
        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
		return $entityManager;
     }
	 
	 
	 public function getEvent($name, $entity)
	 {
 		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
 			->setMockClassName($name)
			->disableOriginalConstructor()
			->getMock();
		return EventMessage::record($Event, $entity);
	 }
	 
	 public function getEntity($id = 1)
	 {
		 $entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\EventSourced')
			->getMock();
		 return $entity;
	 }
	
	public function test_it_can_store_an_event_strem_for_an_entity()
	{
		$em = $this->getEntityManager();
		$em->expects($this->exactly(3))
			->method('persist');
		$entity = $this->getEntity(1);
		$Storage = new DoctrineEventStorage($em);
		$Stream = new EventStream(array(
			$this->getEvent('EntityCreated', $entity),
			$this->getEvent('EntityUpdated', $entity),
			$this->getEvent('EntityDeleted', $entity)
		));
		$Storage->saveStream( new EntityDTO('Entity', '1'), $Stream);
		
	}
	
	public function dont_test_it_can_store_an_event_stream_for_different_entities()
	{
		$Stream = new EventStream(array('event 1', 'event 2', 'event 3'));
		$Stream2 = new EventStream(array('event 4', 'event 5'));
		$expected = array(
			'Entity' => array(1 => array('event 1', 'event 2', 'event 3')),
			'OtherEntity' => array(2 => array('event 4', 'event 5'))
		);
		
		$Storage = new DoctrineEventStorage($this->getEntityManager());
		$Storage->saveStream( new EntityDTO('Entity', '1'), $Stream);
		$Storage->saveStream( new EntityDTO('OtherEntity', 2), $Stream2);
	}
	
	public function dont_test_it_can_load_an_event_stream_for_an_entity()
	{
		$Storage = new DoctrineEventStorage($this->getEntityManager());
		$Stream = new EventStream(array('event 1', 'event 2', 'event 3'));
		$expected = array('Entity' => array(1 => array('event 1', 'event 2', 'event 3')));
		$Storage->saveStream( new EntityDTO('Entity', '1'), $Stream);
		$loadedStream = $Storage->loadStream(new EntityDTO('Entity', 1));
		$this->assertEquals($Stream, $loadedStream);
	}
	
	public function test_it_counts_events_for_an_entity()
	{
	
	}
}

?>