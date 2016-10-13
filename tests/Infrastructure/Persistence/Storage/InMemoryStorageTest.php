<?php

namespace Tests\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\InMemoryStorage;
use Milhojas\Library\ValueObjects\Identity\Id;

use Tests\Infrastructure\Persistence\Storage\StorageObject;

/**
* Description
*/
class InMemoryStorageTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_can_store_an_object()
	{
		$Storage = new InMemoryStorage();
		$Storage->store(new StorageObject(new Id(1)));
		$this->assertEquals(1, $Storage->countAll());
	}
	
	public function test_it_can_store_several_objects()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new StorageObject(new Id($id)));
		}
		$this->assertEquals($count, $Storage->countAll());
	}
	
	public function test_it_can_retrieve_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new StorageObject(new Id($id)));
		}
		for ($id=0; $id < $count; $id++) { 
			$value = $Storage->load(new Id($id));
			$this->assertEquals($value, new StorageObject(new Id($id)));
		}
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	
	public function test_exception_trying_to_load_non_existent_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new StorageObject(new Id($id)));
		}
		$value = $Storage->load(new Id(12));
	}
	
	public function test_it_can_remove_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new StorageObject(new Id($id)));
		}
		$Storage->delete(new StorageObject(new Id(2)));
		$this->assertEquals(9, $Storage->countAll());
	}
	
	/**
	 * @expectedException \OutOfBoundsException
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_exception_trying_to_remove_non_existent_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new StorageObject(new Id($id)));
		}
		$Storage->delete(new StorageObject(new Id(12)));
	}
	
}

?>
