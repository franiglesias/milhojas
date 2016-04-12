<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;


use Milhojas\Infrastructure\Persistence\Storage\Drivers\StorageDriver;
/**
* Description
*/
class InMemoryStorageDriver implements StorageDriver
{
	private $data;
	
	public function __construct()
	{
		$this->data = array();
	}
	
	public function load($id)
	{
		$this->checkStorageKeyExists($id);
		return $this->data[$id];
	}
	public function save($id, $object) 
	{
		$this->data[$id] = $object;
	}
	public function delete($id)
	{
		$this->checkStorageKeyExists($id);
		unset($this->data[$id]);
	}
	public function findAll()
	{
		return $this->data;
	}
	public function countAll() {
		return count($this->data);
	}
	
	private function checkStorageKeyExists($id)
	{
		if (!array_key_exists($id, $this->data)) {
			throw new \OutOfBoundsException(sprintf('Key %s doesn\'t exist.', $id), 1);
		}
	}
}

?>