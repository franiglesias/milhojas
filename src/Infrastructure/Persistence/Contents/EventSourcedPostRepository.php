<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;

use Milhojas\Library\EventSourcing\EventStore\EventStore;
use Milhojas\Library\EventSourcing\DTO\EntityData;

/**
* Repository based on Event Sourcing
*/
class EventSourcedPostRepository implements PostRepository
{
	private $storage;
	
	function __construct(EventStore $storage)
	{
		$this->storage = $storage;
	}
	
	public function get(PostId $id) 
	{
		$Entity = new EntityData('Milhojas\Domain\Contents\Post', $id->getId());
		$Stream = $this->storage->loadStream($Entity);
		return Post::reconstitute($Stream);
	}
	
	public function save(Post $Post)
	{
		$stream = $Post->getEvents();
		$this->storage->saveStream($stream);
	}
	
	public function findSatisfying(\Milhojas\Library\Specification\Specification $Specification) 
	{
		
	}
	
	public function count()
	{
		return $this->storage->countEntitiesOfType('Milhojas\Domain\Contents\Post');
	}
	
	public function getEvents()
	{
		return $this->storage->getEvents();
	}
	
}

?>