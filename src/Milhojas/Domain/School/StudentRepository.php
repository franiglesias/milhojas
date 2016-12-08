<?php

namespace Milhojas\Domain\School;

interface StudentRepository
{
    public function store(Student $student);
    public function get(StudentSpecification $studentSpecification);
}
