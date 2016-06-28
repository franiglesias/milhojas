<?php
namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;

/**
 * Simple generic inmemory storage for objects
 *
 * @author Fran Iglesias
 */
class InMemoryStorage implements StorageInterface{

	private $data;
	
	public function load(Id $id)
	{
		$this->keyExists($id);
		return $this->data[$id->getId()];
	}
	
	public function store($Object)
	{
		$this->data[$Object->getId()->getId()] = $Object;
	}
	
	public function delete($Object)
	{
		$this->keyExists($Object->getId());
		unset($this->data[$Object->getId()->getId()]);
	}
	
	private function keyExists(Id $id)
	{
		if (! isset($this->data[$id->getId()])) {
			throw new \OutOfBoundsException($id->getId().' doesn\'t exists.');
		}
	}
	
}

?>