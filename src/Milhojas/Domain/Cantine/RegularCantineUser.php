<?php

namespace Milhojas\Domain\Cantine;
use Milhojas\Domain\Cantine\CantineUser;

class RegularCantineUser implements CantineUser
{
    private $studentId;
    private $schedule;

    public function __construct($student_id, $schedule)
    {
        $this->studentId = $student_id;
        $this->schedule = $schedule;
    }

    public function isEatingOnDate(\DateTime $date)
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
}
