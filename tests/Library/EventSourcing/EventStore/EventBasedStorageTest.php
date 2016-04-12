<?php

namespace Tests\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventBasedStorage;
use Milhojas\Library\EventSourcing\EventStore\EventBasedStorageDriver;
use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventSourcing\DTO\EntityData;
use Milhojas\Library\ValueObjects\Identity\Id;
use Tests\Library\EventSourcing\Fixtures\EventSourcedEntityDummy;
/**
* Description
*/
class DriverDouble implements EventBasedStorageDriver
{
	private $data = array(
		'1' => 'data for entity 1',
		'2' => 'data for entity 2',
		'3' => 'data for entity 3'
	);
	
	function __construct()
	{
		# code...
	}
	
	public function loadStream(EntityData $entity) {
		return $this->data[$entity->getId()->getId()];
	}
	
	public function saveStream(EventStream $stream) {
		
	}
}

class EventBasedStorageTest extends \PHPUnit_Framework_Testcase {
	
	public function test__EventBasedStorage()
	{
		$storage = new EventBasedStorage('Tests\Library\EventSourcing\Fixtures\EventSourcedEntityDummy', new DriverDouble());
	}
	
	public function test_it_converts_id_to_entity_data()
	{
		$storage = new EventBasedStorage('Tests\Library\EventSourcing\Fixtures\EventSourcedEntityDummy', new DriverDouble());
		$this->assertEquals(new EventSourcedEntityDummy(new Id(1)), $storage->load(new Id(1)));
	}
}

?>