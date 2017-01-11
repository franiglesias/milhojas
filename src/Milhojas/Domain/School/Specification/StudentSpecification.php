<?php

namespace Milhojas\Domain\School\Specification;

use Milhojas\Domain\School\Student;

interface StudentSpecification
{
    public function isSatisfiedBy(Student $student);
}
