<?php

namespace Tests\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\EventBasedStorage;
use Milhojas\Infrastructure\Persistence\Storage\Drivers\InMemoryStorageDriver;
use Milhojas\Library\ValueObjects\Identity\Id;

use Tests\Infrastructure\Persistence\Storage\Doubles\EventSourcedStoreObject;

class EventBasedStorageTest extends \PHPUnit_Framework_Testcase {
	
	public function test__EventBasedStorage()
	{
		$driver = new InMemoryStorageDriver();
		$storage = new EventBasedStorage($driver, 'Tests\Infrastructure\Persistence\Storage\Doubles\EventSourcedStoreObject');
		$object = EventSourcedStoreObject::create(new Id(1), 5);
		$object->doSomething(10);
		$storage->store($object);
		$this->assertEquals(2, $driver->countAll());
	}
	
	public function test_it_loads_an_object_by_id()
	{
		$storage = $this->getStorageWithSavedElements();
		$object = $storage->load(new Id(2));
		$expected = EventSourcedStoreObject::create(new Id(2), 6);
		$expected->doSomething(12);
		$expected->clearEvents();
		$this->assertEquals($expected, $object);
	}
	
	private function getStorageWithSavedElements()
	{
		$driver = new InMemoryStorageDriver();
		$storage = new EventBasedStorage($driver, 'Tests\Infrastructure\Persistence\Storage\Doubles\EventSourcedStoreObject');
		$storage->store($this->getObject(1, 5, 10));
		$storage->store($this->getObject(2, 6, 12));
		$storage->store($this->getObject(3, 10, 20));
		return $storage;
	}
	
	private function getObject($id, $value, $finalValue)
	{
		$object = EventSourcedStoreObject::create(new Id($id), $value);
		$object->doSomething($finalValue);
		return $object;
	}
}
?>