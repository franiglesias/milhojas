<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;


use Milhojas\Infrastructure\Persistence\Storage\Drivers\StorageDriver;
/**
* Simple In Memory Based Storage Driver
*/
class InMemoryStorageDriver implements StorageDriver
{
	private $data;
	
	public function __construct()
	{
		$this->data = array();
	}
	
	public function load($key)
	{
		$this->checkStorageKeyExists($key);
		return $this->data[$key];
	}
	public function save($object) 
	{
		$this->data[$object->getId()] = $object;
	}
	public function delete($object)
	{
		$key = $object->getId();
		$this->checkStorageKeyExists($key);
		unset($this->data[$key]);
	}
	public function findAll($key = null)
	{
		if (!$key) {
			return $this->data;
		}
		$filterByKey = function($value, $k) use($key) {
			return preg_match('/'.str_replace('\\', '\\\\', $key).'/', $k);
		};
		return array_filter($this->data, $filterByKey, ARRAY_FILTER_USE_BOTH);
	}
	
	public function countAll($key = null) {
		return count($this->findAll($key));
	}
	
	private function checkStorageKeyExists($key)
	{
		if (!array_key_exists($key, $this->data)) {
			throw new \OutOfBoundsException(sprintf('Key %s doesn\'t exist.', $key), 1);
		}
	}
}

?>