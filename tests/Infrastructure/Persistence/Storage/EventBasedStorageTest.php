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
		$storage = new EventBasedStorage($driver);
		$object = EventSourcedStoreObject::create(new Id(1), 5);
		$object->doSomething(10);
		$storage->store(new Id(1), $object);
		$this->assertEquals(2, $driver->countAll());
		print_r($driver->findAll());
	}
}
?>