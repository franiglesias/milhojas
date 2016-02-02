<?php
/**
 * Simple generic inmemory storage
 *
 * @author Fran Iglesias
 */
namespace Milhojas\Infrastructure\Persistence\Common;
use Milhojas\Infrastructure\Persistence\Common\StorageInterface;

class InMemoryStorage implements StorageInterface{

	private $data;
	
	public function load($id)
	{
		if (!isset($this->data[$id])) {
			throw new \OutOfBoundsException($id.' doesn\'t exists.');
		}
		return $this->data[$id];
	}
	
	public function store($id, $Object)
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
	
	public function findAll()
	{
		return $this->data;
	}
	
	public function countAll()
	{
		return count($this->data);
	}
	
}

?>