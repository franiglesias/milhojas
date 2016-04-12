<?php

namespace Milhojas\Infrastructure\Persistence\Common;

use Milhojas\Library\ValueObjects\Identity\Id;

interface StorageInterface {
	public function load(Id $id);
	public function store(Id $id, $object);
	public function delete(Id $id);
	public function findAll();
	public function countAll();
}

?>