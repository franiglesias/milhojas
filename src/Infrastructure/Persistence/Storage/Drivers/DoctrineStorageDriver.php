<?php

namespace Milhojas\Infrastructure\Persistence\Storage\Drivers;

use Doctrine\ORM\EntityManager;

class DoctrineStorageDriver implements StorageDriver {

	private $em;
	
	private $entity;
	
	public function __construct(EntityManager $em, $entity)
	{
		$this->em = $em;
		$this->entity = $entity;
	}
	
	public function load($key) {
		$result = $this->em->getRepository($this->entity)->find($key);
		if (!$result) {
			throw new \OutOfBoundsException(sprintf('There is no data %s with id = %s', $this->entity, $key));
		}
		return $result;
	}
	
	public function save($object) {
		$this->em->persist($object);
		$this->em->flush();
		$this->em->clear();
	}
	
	public function delete($object) {
		$this->em->remove($object);
		$this->em->flush();
	}
	
	public function findAll($key = null)
	{
		return $this->em->getRepository($this->entity)->findAll();
	}
	
	public function countAll($key = null)
	{
		return $this->em
			->createQuery('SELECT COUNT(storeobject.id) FROM '.$this->entity.' storeobject')
			->getSingleScalarResult();
		
	}
}

?>