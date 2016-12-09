<?php

namespace Milhojas\Domain\Common\Specification;

use Milhojas\Domain\Common\Student;

class StudentNamed implements StudentServiceSpecification
{
    private $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function isSatisfiedBy(Student $student)
    {
        return $this->name == $student->getFullName();
    }
}
