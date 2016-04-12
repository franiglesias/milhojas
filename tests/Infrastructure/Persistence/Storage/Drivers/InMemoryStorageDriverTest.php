<?php

namespace Tests\Infrastructure\Persistence\Storage\Drivers;

use Milhojas\Infrastructure\Persistence\Storage\Drivers\InMemoryStorageDriver;
use Tests\Infrastructure\Persistence\Storage\Doubles\StoreObject;

class InMemoryStorageDriverTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_can_store_something()
	{
		$storage = new InMemoryStorageDriver();
		$storage->save(1, new StoreObject(1));
		$this->assertEquals(1, $storage->countAll());
	}
	
	public function test_it_can_load_stored_data_by_id()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$this->assertEquals(new StoreObject(2), $storage->load(2));
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function test_it_throws_exception_if_id_does_not_exist()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$storage->load(15);
	}
	
	public function test_it_replaces_a_key_with_new_content_when_saving()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$storage->save(3, new StoreObject(10));
		$this->assertEquals(new StoreObject(10), $storage->load(3));
	}
	
	public function test_it_can_delete_a_key()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$storage->delete(3);
		$this->assertEquals(4, $storage->countAll());
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function test_it_throws_exception_if_id_does_not_exists_on_delete()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$storage->delete(15);
	}
	
	public function test_it_can_return_all_objects()
	{
		$storage = $this->getStorageWithSavedElements(5);
		$expected = array(
			1 => new StoreObject(1),
			2 => new StoreObject(2),
			3 => new StoreObject(3),
			4 => new StoreObject(4),
			5 => new StoreObject(5),
		);
		$this->assertEquals($expected, $storage->findAll());
	}
	
	public function test_it_returns_empty_array_if_no_data()
	{
		$storage = new InMemoryStorageDriver();
		$this->assertEquals(array(), $storage->findAll());
	}
	
	public function test_it_returns_empty_array_if_all_data_was_deleted()
	{
		$storage = $this->getStorageWithSavedElements(3);
		$storage->delete(1);
		$storage->delete(2);
		$storage->delete(3);
		$this->assertEquals(array(), $storage->findAll());
	}
	
	
	private function getStorageWithSavedElements($elements = 5)
	{
		$storage = new InMemoryStorageDriver();
		for ($i=1; $i <= $elements; $i++) { 
			$storage->save($i, new StoreObject($i));
		}
		return $storage;
	}
	
	
}
?>