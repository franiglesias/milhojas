<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;

interface StorageDriver {
	public function load($id);
	public function save($id, $object);
	public function delete($id);
	public function findAll();
	public function countAll();
}

?>