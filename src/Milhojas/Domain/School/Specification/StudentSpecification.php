<?php

namespace Milhojas\Domain\School\Specification;

interface StudentSpecification
{
    public function isSatisfiedBy(Student $student);
}
