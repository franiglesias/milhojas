<?php

namespace Milhojas\Domain\School;

use Milhojas\Library\ValueObjects\Identity\PersonName;

class Student
{
    private $id;
    private $group;
    private $name;

    public function __construct(StudentId $studentId, PersonName $personName, StudentGroup $studentGroup = null)
    {
        $this->id = $studentId;
        $this->name = $personName;
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

    public function getName()
    {
        return $this->name;
    }
}
