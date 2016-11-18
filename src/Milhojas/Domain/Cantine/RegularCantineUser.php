<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\School\StudentId;

/**
 * Represents a Regular Cantine User that uses the Cantine in a week/month basis.
 */
class RegularCantineUser extends CantineUser
{
    protected $schedule;

    /**
     * @param StudentId         $student_id
     * @param MonthWeekSchedule $schedule
     */
    public function __construct(StudentId $student_id, MonthWeekSchedule $schedule)
    {
        $this->studentId = $student_id;
        $this->schedule = $schedule;
    }

    public function isEatingOnDate(\DateTime $date)
    {
        return $this->schedule->isScheduledDate($date);
    }
}
