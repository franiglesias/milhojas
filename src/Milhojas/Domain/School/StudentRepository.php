<?php

namespace Milhojas\Domain\School;

use Milhojas\Domain\School\Specification\StudentSpecification;

interface StudentRepository
{
    public function store(Student $student);
    public function get(StudentSpecification $studentSpecification);
    public function getAll();
}
