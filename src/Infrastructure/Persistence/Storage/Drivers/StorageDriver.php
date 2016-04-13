<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;

interface StorageDriver {
	public function load($key);
	public function save($key, $object);
	public function delete($key);
	public function findAll($key = null);
	public function countAll($key = null);
}

?>