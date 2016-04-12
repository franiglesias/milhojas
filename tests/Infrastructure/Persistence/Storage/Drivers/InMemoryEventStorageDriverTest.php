<?php

namespace Tests\Infrastructure\Persistence\Storage\Drivers;

use Milhojas\Infrastructure\Persistence\Storage\Drivers\InMemoryEventStorageDriver;
use Tests\Infrastructure\Persistence\Storage\Doubles\EventSourcedStoreObject;


class InMemoryEventStorageDriverTest extends \PHPUnit_Framework_Testcase {
	
	public function test__InMemoryEventStorageDriver()
	{
		$object = EventSourcedStoreObject::create(1);
		$storage = new InMemoryEventStorageDriver();
		$storage->save(1, $object);
	}
}
?>