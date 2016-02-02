<?php

namespace Milhojas\Tests\Infrastructure\Persistence\Common;

use \Milhojas\Infrastructure\Persistence\Common\InMemoryStorage;
/**
* Description
*/
class InMemoryStorageTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_can_store_a_value()
	{
		$Storage = new InMemoryStorage();
		$Storage->store(1, 'Value');
		$this->assertEquals(1, $Storage->countAll());
	}
	
	public function test_it_can_store_several_value()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store($id, 'Value '.$id);
		}
		$this->assertEquals($count, $Storage->countAll());
	}
	
	public function test_it_can_retrieve_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store($id, 'Value '.$id);
		}
		for ($id=0; $id < $count; $id++) { 
			$value = $Storage->load($id);
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
			$Storage->store($id, 'Value '.$id);
		}
		$value = $Storage->load(12);
	}
	
	public function test_it_can_remove_a_value_by_id()
	{
		$Storage = new InMemoryStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) { 
			$Storage->store($id, 'Value '.$id);
		}
		$Storage->delete(2);
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
			$Storage->store($id, 'Value '.$id);
		}
		$Storage->delete(12);
	}
	
}

?>