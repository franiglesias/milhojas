<?php

namespace Infrastructure\Persistence\Common;

interface StorageInterface {
	public function load($id);
	public function store($id, $object);
	public function delete($id);
	public function findAll();
	public function countAll();
}

?>