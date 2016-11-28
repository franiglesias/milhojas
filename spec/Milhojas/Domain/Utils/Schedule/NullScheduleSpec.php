<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use PhpSpec\ObjectBehavior;

class NullScheduleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NullSchedule::class);
        $this->shouldImplement(Schedule::class);
    }

    public function it_never_schedule_a_date(\DateTime $date1, \DateTime $date2)
    {
        $this->shouldNotBeScheduledDate($date1);
        $this->shouldNotBeScheduledDate($date2);
    }

    public function it_updates_replacing_itself_with_the_new_schedule(\DateTime $date1, \DateTime $date2)
    {
        $theNewSchedule = new NullSchedule();
        $this->update($theNewSchedule)->shouldBe($theNewSchedule);
    }
}
