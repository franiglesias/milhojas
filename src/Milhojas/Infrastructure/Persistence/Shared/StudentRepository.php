<?php

namespace Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Shared\Mapper\StudentMapper;
use Milhojas\Infrastructure\Persistence\Storage\Storage;
use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;
use Milhojas\Domain\Shared\Student;

class StudentRepository implements StudentServiceRepository
{
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var StudentMapper
     */
    private $mapper;
    public function __construct(Storage $storage, StudentMapper $mapper)
    {
        $this->storage = $storage;
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
    $all = $this->storage->findAll();
    $students = array_map(function ($dto) {
        return $this->mapper->toEntity($dto);
    }, $all);

    return array_filter($students, function ($student) use ($studentServiceSpecification) {
        return $studentServiceSpecification->isSatisfiedBy($student);
    });
}

/**
 * {@inheritdoc}
 */
public function store(Student $student)
{
    $this->storage->store($this->mapper->toDto($student));
}

/**
 * {@inheritdoc}
 */
public function getAll()
{
    throw new \LogicException('Not implemented'); // TODO
}
}
