<?php

namespace Milhojas\Infrastructure\Persistence\Contents;

use Milhojas\Domain\Contents\PostRepository;
use Milhojas\Domain\Contents\PostAssembler;
use Milhojas\Domain\Contents\PostDTOAssembler;
use Doctrine\ORM\Entitymanager;

use Milhojas\Library\Specification\Specification;
use Milhojas\Library\Mapper\Mapper;

class DoctrinePostRepository implements PostRepository {
	
	private $em;
	private $assembler;
	private $mapper;
	private $dtoAssembler;
	
	public function __construct(Entitymanager $em, Mapper $mapper, PostAssembler $assembler, PostDTOAssembler $dtoAssembler)
	{
		$this->em = $em;
		$this->assembler = $assembler;
		$this->mapper = $mapper;
		$this->dtoAssembler = $dtoAssembler;
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
		$map = $this->mapper->map($Post);
		$dto = $this->dtoAssembler->assemble($map);
		$this->em->persist($dto);
		$this->em->flush();
	}
	
	public function countAll()
	{
		return $this->em
			->createQuery('SELECT COUNT(post.id) FROM Contents:Post post')
			->getSingleScalarResult();
	}
	
	public function findSatisfying(Specification $Specification)
	{
		// $data = $this->Storage->findAll();
		// return array_filter($data, array($Specification, 'isSatisfiedBy'));
	}
	
}

?>