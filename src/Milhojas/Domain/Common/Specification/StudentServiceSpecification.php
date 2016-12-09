<?php

namespace Milhojas\Domain\Common\Specification;

use Milhojas\Domain\Common\Student;

interface StudentServiceSpecification
{
    public function isSatisfiedBy(Student $student);
}
