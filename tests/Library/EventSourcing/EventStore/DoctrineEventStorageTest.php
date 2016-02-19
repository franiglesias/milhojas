<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\DoctrineEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;

use Milhojas\Library\EventSourcing\DTO\EventDTO;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;


class DoctrineEventStorageTest extends \PHPUnit_Framework_TestCase
{

	private $Storage;
	private $em;
	
	protected function start_a_new_storage()
	{
		$this->start_entity_manager();
		$this->Storage = new DoctrineEventStorage($this->em);
	}

	protected function simulate_a_storage_returning_events($eventCount)
	{
		$this->start_entity_manager();
		$dtos = $this->prepare_dtos_for_entity($this->getEntity(), $eventCount);
		$repo = $this->getRepository($dtos);
		$this->em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
		$this->Storage = new DoctrineEventStorage($this->em);
	}
	
	protected function store_an_event_stream_with_this_number_of_events($eventCount)
	{
		$Stream = $this->prepare_stream_for_entity($this->getEntity(1, $eventCount), $eventCount);
		$this->em->expects($this->exactly($eventCount))->method('persist');
		$this->em->expects($this->once())->method('flush');
		$this->em->expects($this->once())->method('clear');
		$this->em->expects($this->any())->method('createQuery')->will($this->returnValue($this->getQuerySaving($eventCount)));
		
		$this->Storage->saveStream($Stream);
	}

	protected function store_an_event_stream_with_conflicting_version($eventCount, $badVersionNumber)
	{
		$Stream = $this->prepare_stream_for_entity($this->getEntity(1, $badVersionNumber), $eventCount);
		$storedVersion = $badVersionNumber + 1;
		$this->em->expects($this->any())->method('createQuery')->will($this->returnValue($this->getQuery($storedVersion)));
		$this->Storage->saveStream($Stream);
	}

	protected function storage_should_contain_this_number_of_events($expectedEventCount)
	{
		$this->em->expects($this->once())->method('createQuery')->will($this->returnValue($this->getQuery($expectedEventCount)));
		$this->assertEquals($expectedEventCount, $this->Storage->count($this->getEntity(1, $expectedEventCount-1)));
	}
	
	protected function storage_should_return_an_event_stream()
	{
		$Stream = $this->Storage->loadStream($this->getEntity(1));
		$this->assertInstanceOf('Milhojas\Library\EventSourcing\EventStream', $Stream);
	}
	
	
	protected function storage_should_return_an_event_stream_with_events($expectedCount)
	{
		$Stream = $this->Storage->loadStream($this->getEntity(1));
		$this->assertEquals($expectedCount, $Stream->count());
	}

	private function start_entity_manager()
	{
		$this->em = $this
			->getMockBuilder('Doctrine\ORM\EntityManager')
			->disableOriginalConstructor()
			->getMock();
	}
	
	private function getRepository($dtos)
	{
		$postRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
			->disableOriginalConstructor()
			->getMock();
		$postRepository->expects($this->any())
			->method('findBy')
			->with($this->equalTo( array(
				'entity_type' => 'Entity',
				'entity_id' => 1
			) ))
			->will($this->returnValue( $dtos ));
		return $postRepository;
	}
	
	private function getStreamForEntity($entity)
	{
		return new EventStream($this->getEventsForAnEntity($entity));
	}
	
	protected function getQuery($count)
	{
		// http://h4cc.tumblr.com/post/61502458780/phpunit-mock-for-doctrineormquery
	 
	 	$query = $this
			->getMockBuilder('Doctrine\ORM\AbstractQuery')
			->setMethods(array('getResult', 'setParameter', 'getSingleScalarResult'))
			->disableOriginalConstructor()
			->getMockForAbstractClass();
		$query->expects($this->any())
			->method('getSingleScalarResult')
			->will($this->returnValue($count));
		$query->expects($this->any())
			->method('setParameter')
			->will($this->returnSelf());
		return $query;
	}
	
	protected function getQuerySaving($count)
	{
		// http://h4cc.tumblr.com/post/61502458780/phpunit-mock-for-doctrineormquery
	 
	 	$query = $this
			->getMockBuilder('Doctrine\ORM\AbstractQuery')
			->setMethods(array('getResult', 'setParameter', 'getSingleScalarResult'))
			->disableOriginalConstructor()
			->getMockForAbstractClass();
		$query->expects($this->any())
			->method('getSingleScalarResult')
			->will($this->onConsecutiveCalls(0, 1, 2, 3, 4, 5, 6, 7, 8));
		$query->expects($this->any())
			->method('setParameter')
			->will($this->returnSelf());
		return $query;
	}
	
	
	private function getEvent($name)
	{
		return $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
			->setMockClassName($name)
			->disableOriginalConstructor()
			->getMock();
	}

	private function getEntity($id = 1, $version = -1)
	{
		return new EntityData('Entity', $id, $version);
	}
	
	private function prepare_stream_for_entity($entity, $eventCount)
	{
		$messages = array();
		for ($i=0; $i < $eventCount; $i++) { 
			$event = $this->getEvent('Event_'.$i);
			$messages[] = EventMessage::record($event, $entity);
		}
		return new EventStream($messages);
	}
	
	private function prepare_dtos_for_entity($entity, $eventCount)
	{
		$dtos = array();
		for ($i=0; $i < $eventCount; $i++) { 
			$event = $this->getEvent('Event_'.$i);
			$dtos[] = EventDTO::fromEventMessage(EventMessage::record($event, $entity));
		}
		return $dtos;
	}
	
	public function test_a_new_storage_has_no_events()
	{
		$this->start_a_new_storage();
		$this->storage_should_contain_this_number_of_events(0);
	}
	
	/**
	 * @expectedException Milhojas\Library\EventSourcing\Exceptions\EntityNotFound
	 */
	public function test_throw_exception_if_there_is_no_info_for_entity()
	{
		$this->simulate_a_storage_returning_events(0);
		$this->storage_should_contain_this_number_of_events(0);
		$this->storage_should_return_an_event_stream();
	}
	
	public function test_it_can_store_an_event_strem_for_an_entity()
	{
		$this->start_a_new_storage();
		$this->store_an_event_stream_with_this_number_of_events(3);
		$this->storage_should_contain_this_number_of_events(3);
	}

	public function test_it_can_retrieve_an_event_stream_for_an_entity()
	{
		$this->simulate_a_storage_returning_events(3);
		$this->storage_should_return_an_event_stream();
		$this->storage_should_return_an_event_stream_with_events(3);
	}

	/**
	 * @expectedException Milhojas\Library\EventSourcing\Exceptions\ConflictingVersion
	 */
	public function test_it_detects_a_conflicting_version()
	{
		$this->start_a_new_storage();
		$this->store_an_event_stream_with_conflicting_version(3, 3);
	}
	

}

?>