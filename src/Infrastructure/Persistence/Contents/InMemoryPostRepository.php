<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Library\Specification\SpecificacionInterface;

use Milhojas\Infrastructure\Persistence\Common\InMemoryStorage;
use Milhojas\Infrastructure\Persistence\Common\StorageInterface;


class InMemoryPostRepository implements PostRepository {
	
	private $Storage;
	
	public function __construct(StorageInterface $Storage)
	{
		$this->Storage = $Storage;
	}
	
	public function get(\Milhojas\Domain\Contents\PostId $id)
	{
		try {
			return $this->Storage->load($id->getId());
		} catch (\OutOfBoundsException $e) {
			throw new \Milhojas\Domain\Contents\Exceptions\PostWasNotFound($e->getMessage());
		}
	}
	
	public function save(\Milhojas\Domain\Contents\Post $Post)
	{
		$this->Storage->store($Post->getId()->getId(), $Post);
	}
	
	public function countAll()
	{
		return $this->Storage->countAll();
	}
	
	public function findSatisfying(\Milhojas\Library\Specification\Specification $Specification)
	{
		$data = $this->Storage->findAll();
		return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>