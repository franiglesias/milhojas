<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;

interface StorageDriver {
	public function load($key);
	public function save($object);
	public function delete($object);
	public function findAll($key = null);
	public function countAll($key = null);
}

?>