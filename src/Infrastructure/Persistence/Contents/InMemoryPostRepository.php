<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\PostRepository;
use Domain\Contents\Specifications\PostSpecificationInterface;

use Infrastructure\Persistence\Common\InMemoryStorage;
use Infrastructure\Persistence\Common\StorageInterface;


class InMemoryPostRepository implements PostRepository {
	
	private $Storage;
	
	public function __construct(StorageInterface $Storage)
	{
		$this->Storage = $Storage;
	}
	
	public function get(\Domain\Contents\PostId $id)
	{
		try {
			return $this->Storage->load($id->getId());
		} catch (\OutOfBoundsException $e) {
			throw new \Domain\Contents\Exceptions\PostWasNotFound($e->getMessage());
		}
	}
	
	public function save(\Domain\Contents\Post $Post)
	{
		$this->Storage->store($Post->getId()->getId(), $Post);
	}
	
	public function countAll()
	{
		return $this->Storage->countAll();
	}
	
	public function findSatisfying(\Library\Specification\AbstractSpecification $Specification)
	{
		$data = $this->Storage->findAll();
		return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>