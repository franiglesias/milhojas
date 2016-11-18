<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\Utils\Schedule;
use PhpSpec\ObjectBehavior;

class CantineUserSpec extends ObjectBehavior
{
    public function let(Student $student, Schedule $schedule)
    {
        $this->beConstructedWith($student, $schedule);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUser::class);
    }

    public function it_can_say_if_use_is_eating_on_date(Schedule $schedule)
    {
        $schedule->isScheduledDate(new \DateTime('11/15/2016'))->willReturn(true);
        $this->shouldBeEatingOnDate(new \DateTime('11/15/2016'));
    }
}
