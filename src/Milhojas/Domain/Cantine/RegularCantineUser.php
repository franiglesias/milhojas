<?php

namespace Milhojas\Domain\Cantine;

class RegularCantineUser
{
    private $studentId;
    private $weekDays;
    private $groupId;

    public function __construct($student_id, $days_of_week, $group_id)
    {
        $this->studentId = $student_id;
        $this->weekDays = $days_of_week;
        $this->groupId = $group_id;
    }

    public function getAssignedTurn($argument1, $argument2)
    {
        // TODO: write logic here
    }
}
