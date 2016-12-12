<?php

namespace Milhojas\Domain\Common;

use Milhojas\Domain\Common\Specification\StudentServiceSpecification;

interface StudentServiceRepository
{
    public function get(StudentServiceSpecification $studentServiceSpecification);
    public function find(StudentServiceSpecification $studentServiceSpecification);
}
