<?php

namespace Milhojas\Domain\School;

class Student
{
    private $id;

    public function __construct(StudentId $studentId)
    {
        $this->id = $studentId;
    }

    public function getStudentId()
    {
        return $this->id;
    }
}
