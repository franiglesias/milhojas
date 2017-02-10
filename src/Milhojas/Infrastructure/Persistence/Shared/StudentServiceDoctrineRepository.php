<?php

namespace Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;
use Milhojas\Domain\Shared\Student;
use Milhojas\Infrastructure\Persistence\Shared\Mapper\StudentMapper;
use Doctrine\ORM\EntityManagerInterface;

class StudentServiceDoctrineRepository implements StudentServiceRepository
{
    private $entityManager;
    private $mapper;

    public function __construct(EntityManagerInterface $entityManager, StudentMapper $mapper)
    {
        $this->entityManager = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function get(StudentServiceSpecification $studentServiceSpecification)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function find(StudentServiceSpecification $studentServiceSpecification)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function store(Student $student)
    {
        $this->entityManager->persist($this->mapper->entityToDto($student));
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $results = $this->entityManager->getRepository('Shared:StudentDTO')->findAll();
        foreach ($results as $dto) {
            $response[] = $this->mapper->toEntity($dto);
        }

        return $response;
    }
}
