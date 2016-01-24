<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\PostRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePostRepository implements PostRepositoryInterface {
	
	private $Repository;
	
	public function __construct(EntityRepository $Repository)
	{
		$this->Repository = $Repository;
	}
	
	public function get(\Domain\Contents\PostId $id)
	{
		try {
			return $this->Storage->find($id->getId());
		} catch (\OutOfBoundsException $e) {
			throw new \Domain\Contents\Exceptions\NotFoundPostException($e->getMessage());
		}
	}
	
	public function save(\Domain\Contents\Post $Post)
	{
		// $this->Storage->store($Post->getId()->getId(), $Post);
	}
	
	public function countAll()
	{
		// return $this->Storage->countAll();
	}
	
	public function findSatisfying(\Library\Specification\AbstractSpecification $Specification)
	{
		// $data = $this->Storage->findAll();
		// return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>