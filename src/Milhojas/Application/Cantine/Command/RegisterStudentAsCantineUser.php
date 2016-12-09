<?php

namespace Milhojas\Application\Cantine\Command;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Domain\Common\Student;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;

class RegisterStudentAsCantineUser implements Command
{
    private $student;
    private $schedule;

    public function __construct(Student $student, Schedule $schedule = null)
    {
        $this->student = $student;
        $this->schedule = $schedule ? $schedule : new NullSchedule();
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }
}
