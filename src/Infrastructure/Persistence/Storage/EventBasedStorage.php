<?php

namespace Milhojas\Infrastructure\Persistence\Storage;

use Milhojas\Infrastructure\Persistence\Common\StorageInterface;

use Milhojas\Library\ValueObjects\Identity\Id;

class EventBasedStorage implements StorageInterface
{
	
	function __construct()
	{
		# code...
	}
	
	public function load(Id $id)
	{
		
	}
	public function store(Id $id, $object)
	{
		
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