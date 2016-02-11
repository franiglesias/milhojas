<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\InMemoryEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\EventMessage;

class InMemoryEventStorageTest extends \PHPUnit_Framework_TestCase
{
	
	private function getEvent($name, $entity)
	{
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
			->setMockClassName($name)
			->disableOriginalConstructor()
			->getMock();
		return EventMessage::record($Event, $entity);
	}

	private function getEntity($id = 1)
	{
		$entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\EventSourced')
			->setMockClassName('Entity')
			->getMock();
		$entity->expects($this->any())->method('getEntityId')->will($this->returnValue($this->equalTo($id)));
		return $entity;
	}
	
	
	public function getEventsForAnEntity($entity)
	{
		return array(
			$this->getEvent('EntityCreated', $entity),
			$this->getEvent('EntityUpdated', $entity),
			$this->getEvent('EntityDeleted', $entity)
		);
	}

	private function getStreamForEntity($entity)
	{
		return new EventStream($this->getEventsForAnEntity($entity));
	}
	
	public function test_it_can_store_an_event_strem_for_an_entity()
	{
		$Stream = $this->getStreamForEntity($this->getEntity(1));
		$expected['Entity'][1] = $this->getEventsForAnEntity($this->getEntity(1));
		
		$Storage = new InMemoryEventStorage();
		$Storage->saveStream($Stream);
		print_r($Storage->getEvents());
		$this->assertAttributeEquals($expected, 'events', $Storage);	
	}
		
}

?>