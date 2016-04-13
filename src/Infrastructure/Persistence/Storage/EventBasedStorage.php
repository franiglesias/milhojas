<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Common\StorageInterface;

use Milhojas\Library\ValueObjects\Identity\Id;

class EventBasedStorage implements StorageInterface
{
	private $driver;
	
	function __construct(StorageDriver $driver)
	{
		$this->driver = $driver;
	}
	
	public function load(Id $id)
	{
		// Guess the key based on id and managed entity
		// Load stream of events
		// Return object
	}
	public function store(Id $id, $object)
	{
		// Guess the key
		// Get Event Stream
		// Save object usind driver
		
	}
	public function delete(Id $id)
	{
		
	}
	public function findAll()
	{
		
	}
	public function countAll()
	{
		
	}
}

?>