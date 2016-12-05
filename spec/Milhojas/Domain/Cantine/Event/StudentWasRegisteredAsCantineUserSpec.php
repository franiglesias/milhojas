<?php

namespace spec\Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\Event\StudentWasRegisteredAsCantineUser;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\School\Student;
use Milhojas\Library\EventBus\Event;
use PhpSpec\ObjectBehavior;

class StudentWasRegisteredAsCantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, CantineUser $cantineUser)
    {
        $this->beConstructedWith($student, $cantineUser);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StudentWasRegisteredAsCantineUser::class);
        $this->shouldImplement(Event::class);
        $this->getName()->shouldBe('milhojas.cantine.student_was_registered_as_cantine_user');
    }

    public function it_communicates_student_and_cantine_user(Student $student, CantineUser $cantineUser)
    {
        $this->getStudent()->shouldBe($student);
        $this->getCantineUser()->shouldBe($cantineUser);
    }
}
