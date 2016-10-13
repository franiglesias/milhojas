<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Library\ValueObjects\Identity\Id;

interface StorageInterface {
	public function load(Id $id);
	public function store($object);
	public function delete($object);
}

?>
