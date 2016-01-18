<?php
/**
 * Simple generic inmemory storage
 *
 * @author Fran Iglesias
 */
namespace Infrastructure\Persistence\Common;

class InMemoryStorage {

	private $data;
	
	public function get($id)
	{
		if (!isset($this->data[$id])) {
			throw new \OutOfBoundsException($id.' doesn\'t exists.');
		}
		return $this->data[$id];
	}
	
	public function save($id, $Object)
	{
		$this->data[$id] = $Object;
	}
	
	public function delete($id)
	{
		if (!isset($this->data[$id])) {
			throw new \OutOfBoundsException($id.' doesn\'t exists.');
		}
		unset($this->data[$id]);
	}
	
	public function countAll()
	{
		
		return count($this->data);
	}
}

?>