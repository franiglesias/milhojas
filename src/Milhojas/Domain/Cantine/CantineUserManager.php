<?php

namespace Milhojas\Domain\Cantine;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\RegularCantineUser;

class CantineUserManager
{
    public function applyAsRegular(Student $student, MonthWeekSchedule $schedule)
    {
        return new RegularCantineUser($student->getStudentId(), $schedule);
    }
}
