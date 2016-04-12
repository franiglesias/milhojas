<?php
namespace Milhojas\Infrastructure\Persistence\Common;

use Milhojas\Infrastructure\Persistence\Common\StorageInterface;
use Milhojas\Library\ValueObjects\Identity\Id;

/**
 * Simple generic inmemory storage
 *
 * @author Fran Iglesias
 */

class ObjectId {
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $id;
	}
	
}

class InMemoryObjectStorage implements StorageInterface{

	private $data;
	
	public function __construct()
	{
		$this->data = new \SPLObjectStorage();
	}
	
	public function load(Id $id)
	{
		$this->data->rewind();
		foreach ($this->data as $object) {
			if ($this->data->getInfo() == $id->getId()) {
				return $object;
			}
		}
		throw new \OutOfBoundsException(sprintf('Object with id %s doesn\'t exists', $id->getId()));
		
	}
	
	public function store(Id $id, $Object)
	{
		$this->data->attach($Object, $id->getId());
	}
	
	public function delete(Id $id)
	{
		$this->data->rewind();
		foreach ($this->data as $object) {
			if ($this->data->getInfo() == $id->getId()) {
				$this->data->detach($object);
				return;
			}
		}
		throw new \OutOfBoundsException(sprintf('Object with id %s doesn\'t exists', $id->getId()));
	}
	
	public function findAll()
	{
	}
	
	public function countAll()
	{
		return $this->data->count();
	}
	
}

?>