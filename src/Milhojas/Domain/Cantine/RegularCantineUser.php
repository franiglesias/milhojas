<?php

namespace Milhojas\Domain\Cantine;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\MonthWeekSchedule;

/**
 * Represents a Regular Cantine User that uses the Cantine in a week/month basis
 */
class RegularCantineUser implements CantineUser
{
    private $studentId;
    private $schedule;

/**
 * @param $student_id StudentId the student_id
 * @param $schedule month => [week days] array to define the schedule
 */
    public function __construct($student_id, MonthWeekSchedule $schedule)
    {
        $this->studentId = $student_id;
        $this->schedule = $schedule;
    }

    public function isEatingOnDate(\DateTime $date)
    {
        return $this->schedule->isScheduledDate($date);
    }
}
