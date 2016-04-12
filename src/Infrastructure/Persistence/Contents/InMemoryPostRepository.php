<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Library\Specification\SpecificacionInterface;

use Milhojas\Infrastructure\Persistence\Common\InMemoryStorage;
use Milhojas\Infrastructure\Persistence\Common\StorageInterface;

use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\Exceptions\PostWasNotFound;

use Milhojas\Library\Specification\Specification;

class InMemoryPostRepository implements PostRepository {
	
	private $Storage;
	
	public function __construct(StorageInterface $Storage)
	{
		$this->Storage = $Storage;
	}
	
	public function get(PostId $id)
	{
		try {
			return $this->Storage->load($id);
		} catch (\OutOfBoundsException $e) {
			throw new PostWasNotFound($e->getMessage());
		}
	}
	
	public function save(Post $Post)
	{
		$this->Storage->store($Post->getId(), $Post);
	}
	
	public function countAll()
	{
		return $this->Storage->countAll();
	}
	
	public function findSatisfying(Specification $Specification)
	{
		$data = $this->Storage->findAll();
		return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>