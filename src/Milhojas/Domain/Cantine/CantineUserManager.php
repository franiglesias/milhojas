<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\School\Student;

class CantineUserManager
{
    private $repository;

    public function __construct(CantineUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyAsRegular(Student $student, MonthWeekSchedule $schedule)
    {
        return new RegularCantineUser($student->getStudentId(), $schedule);
    }

    public function buyTickets(Student $student, $dates)
    {
        return new TicketCantineUser($student->getStudentId(), $dates);
    }
}
