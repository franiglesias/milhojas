<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;

use Milhojas\Infrastructure\Persistence\Storage\StorageInterface;
use Milhojas\Library\EventSourcing\DTO\EntityData;

/**
* Repository based on Event Sourcing
*/
class EventBasedPostRepository implements PostRepository
{
	private $storage;
	
	function __construct(StorageInterface $storage)
	{
		$this->storage = $storage;
	}
	
	public function get(PostId $id) 
	{
		return $this->storage->load($id);
	}
	
	public function save(Post $Post)
	{
		$this->storage->store($Post);
	}
	
	public function findSatisfying(\Milhojas\Library\Specification\Specification $Specification) 
	{
		
	}
	
	public function count()
	{
		return $this->storage->countAll('Milhojas\Domain\Contents\Post:');
	}
	
}

?>