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
		$this->keyExists($id);
		return $this->data[$id];
	}
	
	public function store($id, $Object)
	{
		$this->data[$id] = $Object;
	}
	
	public function delete($id)
	{
		$this->keyExists($id);
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
	
	private function keyExists($id)
	{
		if (! isset($this->data[$id])) {
			throw new \OutOfBoundsException($id.' doesn\'t exists.');
		}
	}
	
}

?>