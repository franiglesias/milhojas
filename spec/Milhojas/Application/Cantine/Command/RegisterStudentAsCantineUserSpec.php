<?php

namespace spec\Milhojas\Application\Cantine\Command;

use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUser;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use PhpSpec\ObjectBehavior;

class RegisterStudentAsCantineUserSpec extends ObjectBehavior
{
    public function let(Student $student)
    {
        $this->beConstructedWith($student);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterStudentAsCantineUser::class);
        $this->shouldImplement(Command::class);
    }

    public function it_can_get_Student(Student $student)
    {
        $this->getStudent()->shouldBe($student);
    }

    public function it_has_null_schedule()
    {
        $this->getSchedule()->shouldHaveType(NullSchedule::class);
    }

    public function it_can_be_constructed_with_schedule(Student $student, Schedule $schedule)
    {
        $this->beConstructedWith($student, $schedule);
        $this->getStudent()->shouldBe($student);
        $this->getSchedule()->shouldBe($schedule);
    }
}
