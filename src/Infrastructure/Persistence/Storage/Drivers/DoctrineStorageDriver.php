<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;

class DoctrineStorageDriver implements StorageDriver {
	public function load($key) {}
	public function save($key, $object) {}
	public function delete($key) {}
	public function findAll($key = null) {}
	public function countAll($key = null) {}
}

?>