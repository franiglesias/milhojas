<?php

namespace Tests\Milhojas\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\InMemoryEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityVersionData;

use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\EventStream\EventMessage;

use Milhojas\Library\ValueObjects\Identity\Id;

class InMemoryEventStorageTest extends \PHPUnit_Framework_TestCase
{
	private $Storage;
	
	protected function start_a_new_storage()
	{
		$this->Storage = new InMemoryEventStorage();
	}
	
	protected function store_an_event_stream_with_this_number_of_events($eventCount)
	{
		$Stream = $this->prepare_stream_for_entity($this->getEntity(1, $eventCount), $eventCount);
		$this->Storage->saveStream($Stream);
	}

	protected function store_an_event_stream_with_conflicting_version($eventCount, $badVersionNumber)
	{
		$Stream = $this->prepare_stream_for_entity($this->getEntity(1, $badVersionNumber), $eventCount);
		$this->Storage->saveStream($Stream);
	}

	protected function storage_should_contain_this_number_of_events($expectedEventCount)
	{
		$this->assertEquals($expectedEventCount, $this->Storage->count($this->getEntity(1, $expectedEventCount-1)));
	}
	
	protected function storage_should_return_an_event_stream()
	{
		$Stream = $this->Storage->loadStream($this->getEntity(1));
		$this->assertInstanceOf('Milhojas\Library\EventSourcing\EventStream\EventStream', $Stream);
	}
	
	protected function storage_should_return_an_event_stream_with_events($expectedCount)
	{
		$Stream = $this->Storage->loadStream($this->getEntity(1));
		$this->assertEquals($expectedCount, $Stream->count());
	}
	
	private function getEvent($name)
	{
		return $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\Event')
			->setMockClassName($name)
			->disableOriginalConstructor()
			->getMock();
	}

	private function getEntity($id = 1, $version = -1)
	{
		return new EntityVersionData('Entity', new Id($id), $version);
	}
	
	private function prepare_stream_for_entity($entity, $eventCount)
	{
		$stream = new EventStream();
		for ($i=0; $i < $eventCount; $i++) { 
			$event = $this->getEvent('Event_'.$i);
			$stream->recordThat(EventMessage::record($event, $entity));
		}
		return $stream;
	}
	
	public function test_a_new_storage_has_no_events()
	{
		$this->start_a_new_storage();
		$this->storage_should_contain_this_number_of_events(0);
	}
	
	/**
	 * @expectedException Milhojas\Library\EventSourcing\Exceptions\EntityNotFound
	 */
	public function test_throw_exception_if_there_id_no_info_for_entity()
	{
		$this->start_a_new_storage();
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
		$this->start_a_new_storage();
		$this->store_an_event_stream_with_this_number_of_events(3);
		$this->storage_should_return_an_event_stream();
		$this->storage_should_return_an_event_stream_with_events(3);
	}

	/**
	 * @expectedException Milhojas\Library\EventSourcing\Exceptions\ConflictingVersion
	 */
	public function test_it_detects_a_conflicting_version()
	{
		$this->start_a_new_storage();
		$this->store_an_event_stream_with_this_number_of_events(5);
		$this->store_an_event_stream_with_conflicting_version(3, 3);
	}
		
}

?>