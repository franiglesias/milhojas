<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

/**
 * Represents an Extracurricular Activity in which a Student could be enrolled
 * It is a Value Object.
 */
class Extracurricular
{
    private $name;
    private $schedule;

    public function __construct($name, WeeklySchedule $weeklySchedule)
    {
        $this->name = $name;
        $this->schedule = $weeklySchedule;
    }

    /**
     * @return string Name of the extracurricular activity
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Tells if Extracurricular Activiy runs on date $date.
     *
     * @param \DateTime $date
     *
     * @return bool runs on that date
     */
    public function runsOnDate(\DateTime $date)
    {
        return $this->schedule->isScheduledDate($date);
    }
}
