<?php

namespace Tests\Library\EventSourcing\EventStore;

use Tests\Infrastructure\Persistence\Common\DoctrineTestCase;
use Milhojas\Library\EventSourcing\EventStore\DoctrineEventStorage;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\EventSourcing\DTO\EntityVersionData;
use Milhojas\Library\EventSourcing\EventStream\EventMessage;
use Milhojas\Library\EventSourcing\EventStream\EventMessageEnvelope;
use Milhojas\Library\EventSourcing\EventStream\EventStream;

use Milhojas\Library\ValueObjects\Identity\Id;
use Milhojas\Library\EventBus\Event;

use Tests\Library\EventSourcing\EventStore\Fixtures\EventDouble;


class DoctrineEventStorageTest extends DoctrineTestCase
{
    /**
     * Set up repository test
     */
    public function setUp()
    {
        $this->loadFixturesFromDirectory(__DIR__ . '/Fixtures');
    }

	public function test_it_loads_stream_with_3_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Entity', new Id(1)));
		$this->assertEquals(3, $result->count());
	}

	public function test_it_loads_other_stream_with_4_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Other', new Id(1)));
		$this->assertEquals(4, $result->count());
	}

	public function test_it_loads_entity_2_stream_with_6_events()
	{
		$storage = new DoctrineEventStorage($this->em);
		$result = $storage->loadStream(new EntityData('Entity', new Id(2)));
		$this->assertEquals(6, $result->count());
	}
	
	public function test_it_can_count_enitites_stored()
	{
		$storage = new DoctrineEventStorage($this->em);
		$this->assertEquals(2, $storage->countEntitiesOfType('Entity'));
		$this->assertEquals(1, $storage->countEntitiesOfType('Other'));
	}

	public function test_it_can_count_events_for_an_entity()
	{
		$storage = new DoctrineEventStorage($this->em);
		$this->assertEquals(3, $storage->count(new EntityData('Entity', new Id(1), 0)));
		$this->assertEquals(4, $storage->count(new EntityData('Other', new Id(1), 0)));
		$this->assertEquals(6, $storage->count(new EntityData('Entity', new Id(2), 0)));
	}
	
	public function test_it_can_store_a_stream()
	{
		$storage = new DoctrineEventStorage($this->em);
		$stream = $this->prepareEventStream('Entity', new Id(3), 5);
		$storage->saveStream($stream);
		$this->assertEquals(3, $storage->countEntitiesOfType('Entity'));
		$this->assertEquals(5, $storage->count(new EntityData('Entity', new Id(3), 0)));
	}

	public function test_it_can_save_a_stream_and_load_it_and_remains_equal()
	{
		$storage = new DoctrineEventStorage($this->em);
		$stream = $this->prepareEventStream('Entity', new Id(3), 5);
		$storage->saveStream($stream);
		$loaded = $storage->loadStream(new EntityData('Entity', new Id(3)));
		$this->assertEquals($stream, $loaded);
	}
	
	private function prepareEventStream($entity, $id, $maxVersion)
	{
		$stream = new EventStream();
		for ($version=1; $version <= $maxVersion; $version++) { 
			$message = new EventMessage(new EventDouble($id), new EntityVersionData($entity, $id, $version), EventMessageEnvelope::now());
			$stream->recordThat($message);
		}
		return $stream;
	}

}

?>