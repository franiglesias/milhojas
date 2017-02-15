<?php

namespace Milhojas\Infrastructure\Persistence\Shared;

use Milhojas\Domain\Shared\StudentServiceRepository;
use Milhojas\Domain\Shared\Exception\StudentServiceException;
use RulerZ\Spec\Specification;
use Milhojas\Domain\Shared\Student;

class StudentServiceInMemoryRepository implements StudentServiceRepository
{
    private $students = [];
    /**
     * {@inheritdoc}
     */
    public function get(Specification $studentServiceSpecification)
    {
        foreach ($this->students as $student) {
            if ($studentServiceSpecification->isSatisfiedBy($student)) {
                return $student;
            }
        }
        throw new StudentServiceException('Student not found!');
    }

    public function store(Student $student)
    {
        $this->students[] = $student;
    }

    /**
     * {@inheritdoc}
     */
    public function find(Specification $studentServiceSpecification)
    {
        $found = [];
        foreach ($this->students as $student) {
            if ($studentServiceSpecification->isSatisfiedBy($student)) {
                $found[] = $student;
            }
        }

        return $found;
    }
    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->students;
    }
}
