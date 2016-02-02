<?php

namespace Milhojas\Tests\Infrastructure\Persistence\Common;

use \Milhojas\Infrastructure\Persistence\Common\InMemoryObjectStorage;

class MyClass {
	private $value;
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	public function getValue()
	{
		return $this->value;
	}
}
/**
* Description
*/
class InMemoryObjectStorageTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_can_store_a_value()
	{
		$Storage = new InMemoryObjectStorage();
		$Storage->store(1, new MyClass(1));
		$this->assertEquals(1, $Storage->countAll());
	}
	
	
	public function test_it_can_store_several_values()
	{
		$Storage = new InMemoryObjectStorage();
		$Storage->store(1, new MyClass(1));
		$Storage->store(2, new MyClass(2));
		$Storage->store(3, new MyClass(3));
		$this->assertEquals(3, $Storage->countAll());
	}
	

	public function test_it_can_retrieve_a_value_by_id()
	{
		$Storage = new InMemoryObjectStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) {
			$Storage->store($id, new MyClass($id));
		}
		for ($id=0; $id < $count; $id++) {
			$this->assertEquals(new MyClass($id), $Storage->load($id));
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
		$Storage = new InMemoryObjectStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) {
			$Storage->store($id, new MyClass($id));
		}
		$value = $Storage->load(12);
	}

	public function test_it_can_remove_a_value_by_id()
	{
		$Storage = new InMemoryObjectStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) {
			$Storage->store($id,  new MyClass($id));
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
		$Storage = new InMemoryObjectStorage();
		$count = 10;
		for ($id=0; $id < $count; $id++) {
			$Storage->store($id,  new MyClass($id));
		}
		$Storage->delete(12);
	}

}

?>