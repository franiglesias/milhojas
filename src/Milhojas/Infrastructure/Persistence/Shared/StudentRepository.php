<?php

namespace Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Infrastructure\Persistence\Storage\Storage;
use Milhojas\Domain\Shared\StudentServiceRepository;
use RulerZ\Spec\Specification;
use Milhojas\Domain\Shared\Student;

class StudentRepository implements StudentServiceRepository
{
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Specification $studentServiceSpecification)
    {
        $students = $this->storage->findBy($studentServiceSpecification);

        return array_reduce($students, function ($result, $student) use ($studentServiceSpecification) {
            if ($studentServiceSpecification->isSatisfiedBy($student)) {
                $result = $student;
            }

            return $result;
        }, null);
    }

    /**
     * {@inheritdoc}
     */
    public function find(Specification $studentServiceSpecification)
    {
        $students = $this->storage->findBy($studentServiceSpecification);

        return array_filter($students, [$studentServiceSpecification, 'isSatisfiedBy']);
    }

    /**
     * {@inheritdoc}
     */
    public function store(Student $student)
    {
        $this->storage->store($student);
    }

    public function getAll()
    {
        return $this->storage->findAll();
    }
}
