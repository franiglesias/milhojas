<?php

namespace Milhojas\Domain\School;

use Milhojas\Library\ValueObjects\Identity\PersonName;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Domain\Extracurricular\Activity;

class Student
{
    private $id;
    private $group;
    private $name;
    private $allergens;
    private $extracurricular = [];

    public function __construct(StudentId $studentId, PersonName $personName, Allergens $allergens, StudentGroup $studentGroup = null)
    {
        $this->id = $studentId;
        $this->name = $personName;
        $this->group = $studentGroup ? $studentGroup : new NewStudentGroup();
        $this->allergens = $allergens;
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

    public function getAllergies()
    {
        return $this->allergens;
    }

    public function enrollToExtracurricular(Activity $activity)
    {
        $this->extracurricular[$activity->getName()] = $activity;
    }

    public function isEnrolledToExtracurricular($activityName)
    {
        return isset($this->extracurricular[$activityName]);
    }
}
