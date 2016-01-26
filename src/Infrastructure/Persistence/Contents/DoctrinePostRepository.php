<?php

namespace Infrastructure\Persistence\Contents;

use Domain\Contents\PostRepositoryInterface;
use Doctrine\ORM\Entitymanager;

class DoctrinePostRepository implements PostRepositoryInterface {
	
	private $em;
	
	public function __construct(Entitymanager $em)
	{
		$this->em = $em;
	}
	
	public function get(\Domain\Contents\PostId $id)
	{
		try {
			
			
		} catch (\OutOfBoundsException $e) {
			throw new \Domain\Contents\Exceptions\NotFoundPostException($e->getMessage());
		}
	}
	
	public function save(\Domain\Contents\Post $Post)
	{
		$dto = $Post->getAsDto();
		$this->em->persist($dto);
		$this->em->flush();
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