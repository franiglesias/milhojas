<?php

namespace Milhojas\Domain\Utils;

class MonthWeekSchedule
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
        if (! isset($this->schedule[($month)])) {
            return false;
        }
        if (! in_array($dayOfWeek, $this->schedule[$month])) {
            return false;
        }
        return true;
    }
}
