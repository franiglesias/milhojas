<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\PostRepositoryInterface;
use Domain\Contents\Specifications\PostSpecificationInterface;

use Infrastructure\Persistence\Common\InMemoryStorage;


class InMemoryPostRepository implements PostRepositoryInterface {
	
	private $Storage;
	
	public function __construct(InMemoryStorage $Storage)
	{
		$this->Storage = $Storage;
	}
	
	public function get(\Domain\Contents\PostId $id)
	{
		try {
			return $this->Storage->get($id->getId());
		} catch (\OutOfBoundsException $e) {
			throw new \Domain\Contents\Exceptions\NotFoundPostException($e->getMessage());
		}
	}
	
	public function save(\Domain\Contents\Post $Post)
	{
		$this->Storage->save($Post->getId()->getId(), $Post);
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