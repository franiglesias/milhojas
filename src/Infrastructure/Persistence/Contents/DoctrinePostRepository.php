<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Domain\Contents\PostAssembler;
use Doctrine\ORM\Entitymanager;

class DoctrinePostRepository implements PostRepository {
	
	private $em;
	private $mapper;
	
	public function __construct(Entitymanager $em, PostAssembler $mapper)
	{
		$this->em = $em;
		$this->mapper = $mapper;
	}
	
	public function get(\Milhojas\Domain\Contents\PostId $id)
	{
		try {
			
			
		} catch (\OutOfBoundsException $e) {
			throw new \Milhojas\Domain\Contents\Exceptions\PostWasNotFound($e->getMessage());
		}
	}
	
	public function save(\Milhojas\Domain\Contents\Post $Post)
	{
		$dto = $this->mapper->map($Post, new \Milhojas\Domain\Contents\DTO\PostDTO());
		$this->em->persist($dto);
		$this->em->flush();
	}
	
	public function countAll()
	{
		return $this->em
			->createQuery('SELECT COUNT(post.id) FROM Contents:Post post')
			->getSingleScalarResult();
	}
	
	public function findSatisfying(\Milhojas\Library\Specification\SpecificationInterface $Specification)
	{
		// $data = $this->Storage->findAll();
		// return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>