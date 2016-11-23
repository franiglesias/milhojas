<?php

namespace Milhojas\Domain\School;

class Student
{
    private $id;
    private $group;

    public function __construct(StudentId $studentId, StudentGroup $studentGroup = null)
    {
        $this->id = $studentId;
        $this->group = $studentGroup ? $studentGroup : new NewStudentGroup();
    }

    public function getStudentId()
    {
        return $this->id;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function assignGroup(StudentGroup $studentGroup)
    {
        $this->group = $studentGroup;
    }
}
