<?php

namespace Milhojas\Domain\Shared;

use RulerZ\Spec\Specification;

interface StudentServiceRepository
{
    public function get(Specification $studentServiceSpecification);
    public function find(Specification $studentServiceSpecification);

    public function store(Student $student);

    public function getAll();
}
