<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Doctrine\ORM\EntityManagerInterface;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use Milhojas\Infrastructure\Persistence\Mapper\Mapper;

class CantineUserDoctrineRepository implements CantineUserRepository
{
    private $em;
    private $mapper;

    public function __construct(EntityManagerInterface $entityManager, Mapper $mapper)
    {
        $this->em = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function store(CantineUser $user)
    {
        $dto = $this->mapper->entityToDto($user);
        $this->em->persist($dto);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve($id)
    {
        $repository = $this->em->getRepository('Entity\CantineUser');
        $dto = $repository->find($id);

        return $this->mapper->dtoToEntity($dto);
    }

    /**
     * {@inheritdoc}
     */
    public function get(CantineUserSpecification $cantineUserSpecification)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function find(CantineUserSpecification $cantineUserSpecification)
    {
        return null;
    }
}
