<?php

namespace Milhojas\Domain\Utils;

class MonthWeekSchedule implements Schedule
{
    private $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function isScheduledDate(\DateTime $date)
    {
        return $this->thereIsAppointmentToThisDate($date);
    }

    private function thereIsAppointmentToThisDate(\DateTime $date)
    {
        list($dayOfWeek, $month) = explode(' ', strtolower($date->format('l F')));
        if (!isset($this->schedule[($month)])) {
            return false;
        }
        if (!in_array($dayOfWeek, $this->schedule[$month])) {
            return false;
        }

        return true;
    }

    public function update(Schedule $delta)
    {
        $updated = array_merge($this->schedule, $delta->schedule);

        return new static($updated);
    }
}
