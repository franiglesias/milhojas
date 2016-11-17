<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\School\StudentId;

class TicketCantineUser extends CantineUser
{
    private $dates;

    public function __construct(StudentId $student_id, $dates)
    {
        $this->studentId = $student_id;
        $this->dates = $dates;
    }

    public function isEatingOnDate(\DateTime $date)
    {
        return in_array($date, $this->dates);
    }
}
