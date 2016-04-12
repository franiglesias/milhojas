<?php
namespace Milhojas\Infrastructure\Persistence\Common;

use Milhojas\Infrastructure\Persistence\Common\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;
/**
 * Simple generic inmemory storage
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
	
	public function store(Id $id, $Object)
	{
		$this->data[$id->getId()] = $Object;
	}
	
	public function delete(Id $id)
	{
		$this->keyExists($id);
		unset($this->data[$id->getId()]);
	}
	
	public function findAll()
	{
		return $this->data;
	}
	
	public function countAll()
	{
		return count($this->data);
	}
	
	private function keyExists(Id $id)
	{
		if (! isset($this->data[$id->getId()])) {
			throw new \OutOfBoundsException($id->getId().' doesn\'t exists.');
		}
	}
	
}

?>