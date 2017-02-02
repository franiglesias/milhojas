<?php

namespace Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;
use Milhojas\Domain\Shared\Student;
use Milhojas\Application\Shared\DTO\StudentDTO;
use Doctrine\ORM\EntityManagerInterface;

class StudentServiceDoctrineRepository implements StudentServiceRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        $dto = StudentDTO::mapFromStudent($student);
        print_r($dto);
        $this->entityManager->persist($dto);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
