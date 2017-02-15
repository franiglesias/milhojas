<?php

namespace Milhojas\Domain\Shared\Specification;

use Milhojas\Domain\Shared\Student;

interface Specification
{
    public function isSatisfiedBy(Student $student);
}
