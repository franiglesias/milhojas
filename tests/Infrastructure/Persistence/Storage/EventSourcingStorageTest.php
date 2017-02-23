<?php

namespace Tests\EventSourcing\EventStore;

use Milhojas\Infrastructure\Persistence\Storage\EventSourcingStorage;
use Milhojas\EventSourcing\EventStore\InMemoryEventStore;

use Milhojas\EventSourcing\EventStream\EventStream;
use Milhojas\EventSourcing\EventStream\EventMessage;
use Milhojas\EventSourcing\DTO\EntityDTO;

use Milhojas\Library\ValueObjects\Identity\Id;

use Tests\EventSourcing\Fixtures\EventDouble;

use Tests\EventSourcing\Fixtures\EventSourcedEntityDummy;
use Tests\EventSourcing\Fixtures\CreationEvent;
use Tests\EventSourcing\Fixtures\ModificationEvent;

class EventSourcingStorageTest extends \PHPUnit_Framework_TestCase {
	
	private $repo;
	private $storage;
	private $entityType;
	
	public function setUp()
	{
		$entity = get_class(new EventSourcedEntityDummy(new Id(1)));
		$this->storage = new InMemoryEventStore();
		$this->createFixtures($entity, new Id(1));
		$this->createFixtures($entity, new Id(2));
		$this->repo = new EventSourcingStorage($this->storage);
		$this->repo->setEntityType($entity);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_it_fails_if_not_entity_defined()
	{
		$this->storage = new InMemoryEventStore();
		$this->repo = new EventSourcingStorage($this->storage);
		$object = $this->repo->load(new Id(1));
	}
	
	public function test_it_reconstitutes_right_object_from_repository()
	{
		$object = $this->repo->load(new Id(1));
		$this->assertInstanceOf('\Tests\EventSourcing\Fixtures\EventSourcedEntityDummy', $object);
	}
	
	public function test_it_retrieves_the_right_id()
	{
		$object = $this->repo->load(new Id(1));
		$this->assertEquals(new Id(1), $object->getId());
	}
	
	public function test_it_retrieves_the_right_version()
	{
		$object = $this->repo->load(new Id(1));
		$this->assertEquals(3, $object->getVersion());
	}
	
	public function test_it_retrieves_the_last_changes_in_entity($value='')
	{
		$object = $this->repo->load(new Id(1));
		$this->assertEquals('last value', $object->getValue());
	}
	
	public function test_it_saves_and_object_to_event_sourced_storage()
	{
		$id = new Id(3);
		$this->repo->store($this->createObject($id));
		$object = $this->repo->load($id);
		$this->assertInstanceOf('\Tests\EventSourcing\Fixtures\EventSourcedEntityDummy', $object);
		$this->assertEquals($id, $object->getId());
		$this->assertEquals(2, $object->getVersion());
	}
	
	public function test_it_can_retrieve_a_specific_version()
	{
		$object = $this->repo->load(new Id(1), 2);
		$this->assertInstanceOf('\Tests\EventSourcing\Fixtures\EventSourcedEntityDummy', $object);
		$this->assertEquals('new value', $object->getValue());
		$this->assertEquals(2, $object->getVersion());
	}
	
	private function createFixtures($entity, $id)
	{
		$stream = new EventStream();
		$stream->recordThat(EventMessage::record(new CreationEvent($id), new EntityDTO($entity, $id, 1)));
		$stream->recordThat(EventMessage::record(new ModificationEvent('new value'), new EntityDTO($entity, $id, 2)));
		$stream->recordThat(EventMessage::record(new ModificationEvent('last value'), new EntityDTO($entity, $id, 3)));
		$this->storage->saveStream($stream);
	}
	
	private function createObject($id)
	{
		$object = new EventSourcedEntityDummy();
		$object->recordThat(new CreationEvent($id));
		$object->recordThat(new ModificationEvent('new value'));
		return $object;
	}
	
	
}
?>
