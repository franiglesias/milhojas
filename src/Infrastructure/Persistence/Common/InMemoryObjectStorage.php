<?php
/**
 * Simple generic inmemory storage
 *
 * @author Fran Iglesias
 */
namespace Milhojas\Infrastructure\Persistence\Common;
use Milhojas\Infrastructure\Persistence\Common\StorageInterface;

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
	
	public function load($id)
	{
		$this->data->rewind();
		foreach ($this->data as $object) {
			if ($this->data->getInfo() == $id) {
				return $object;
			}
		}
		throw new \OutOfBoundsException(sprintf('Object with id %s doesn\'t exists', $id));
		
	}
	
	public function store($id, $Object)
	{
		$this->data->attach($Object, $id);
	}
	
	public function delete($id)
	{
		$this->data->rewind();
		foreach ($this->data as $object) {
			if ($this->data->getInfo() == $id) {
				$this->data->detach($object);
				return;
			}
		}
		throw new \OutOfBoundsException(sprintf('Object with id %s doesn\'t exists', $id));
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