<?php

namespace Milhojas\Domain\Shared\Specification;

use Milhojas\Domain\Shared\Student;

interface StudentServiceSpecification
{
    public function isSatisfiedBy(Student $student);
}
