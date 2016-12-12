<?php

namespace Milhojas\Domain\Shared;

use Milhojas\Domain\Shared\Specification\StudentServiceSpecification;

interface StudentServiceRepository
{
    public function get(StudentServiceSpecification $studentServiceSpecification);
    public function find(StudentServiceSpecification $studentServiceSpecification);
}
