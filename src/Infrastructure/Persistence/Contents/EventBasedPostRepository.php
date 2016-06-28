<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;

use Milhojas\Domain\Contents\Exceptions\PostWasNotFound;

use Milhojas\Infrastructure\Persistence\Storage\EventSourcingStorageInterface;

/**
* Repository based on Event Sourcing
*/
class EventBasedPostRepository implements PostRepository
{
	private $storage;
	
	function __construct(EventSourcingStorageInterface $storage)
	{
		$this->storage = $storage;
		$this->storage->setEntityType('Milhojas\Domain\Contents\Post');
	}
	
	public function get(PostId $id) 
	{
		try {
			return $this->storage->load($id);
		} catch (\OutOfBoundsException $e) {
			throw new PostWasNotFound($e->getMessage());
		}
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