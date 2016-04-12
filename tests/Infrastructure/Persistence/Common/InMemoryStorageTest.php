<?php

namespace Tests\Infrastructure\Persistence\Common;

use \Milhojas\Infrastructure\Persistence\Common\InMemoryStorage;
use Milhojas\Library\ValueObjects\Identity\Id;

/**
* Description
*/
class InMemoryStorageTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_can_store_a_value()
	{
		$Storage = new InMemoryStorage();
		$Storage->store(new Id(1), 'Value');
		$this->assertEquals(1, $Storage->countAll());
	}
	
	public function test_it_can_store_several_value()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new Id($id), 'Value '.$id);
		}
		$this->assertEquals($count, $Storage->countAll());
	}
	
	public function test_it_can_retrieve_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new Id($id), 'Value '.$id);
		}
		for ($id=0; $id < $count; $id++) { 
			$value = $Storage->load(new Id($id));
			$this->assertEquals('Value '.$id, $value);
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
			$Storage->store(new Id($id), 'Value '.$id);
		}
		$value = $Storage->load(new Id(12));
	}
	
	public function test_it_can_remove_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store(new Id($id), 'Value '.$id);
		}
		$Storage->delete(new Id(2));
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
			$Storage->store(new Id($id), 'Value '.$id);
		}
		$Storage->delete(new Id(12));
	}
	
}

?>