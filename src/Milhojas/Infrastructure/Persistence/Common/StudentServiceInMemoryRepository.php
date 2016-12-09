<?php

namespace Milhojas\Infrastructure\Persistence\Common;

use Milhojas\Domain\Common\StudentServiceRepository;
use Milhojas\Domain\Common\Exception\StudentServiceException;
use Milhojas\Domain\Common\Specification\StudentServiceSpecification;
use Milhojas\Domain\Common\Student;

class StudentServiceInMemoryRepository implements StudentServiceRepository
{
    private $students = [];
    /**
     * {@inheritdoc}
     */
    public function get(StudentServiceSpecification $studentServiceSpecification)
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
}
