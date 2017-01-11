<?php

namespace Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Utils\Schedule\WeeklySchedule;

class Activity
{
    private $name;
    private $time;
    private $schedule;

    /**
     * @param string         $name
     * @param string         $time
     * @param WeeklySchedule $schedule
     */
    public function __construct($name, $time, WeeklySchedule $schedule)
    {
        $this->name = $name;
        $this->time = $time;
        $this->schedule = $schedule;
    }
    public static function createFrom($name, $time, WeeklySchedule $weeklySchedule)
    {
        return new self($name, $time, $weeklySchedule);
    }

    public function getTime()
    {
        return $this->time;
    }
    public function getName()
    {
        return $this->name;
    }

    public function isScheduledFor(\DateTimeInterface $date)
    {
        return $this->schedule->isScheduledDate($date);
    }
}
