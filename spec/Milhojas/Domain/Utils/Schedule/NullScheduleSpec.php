<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use League\Period\Period;
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

    public function it_never_schedule_a_date(\DateTimeImmutable $date1, \DateTimeImmutable $date2)
    {
        $this->shouldNotBeScheduledDate($date1);
        $this->shouldNotBeScheduledDate($date2);
    }

    public function it_updates_replacing_itself_with_the_new_schedule(\DateTimeImmutable $date1, \DateTimeImmutable $date2)
    {
        $theNewSchedule = new NullSchedule();
        $this->update($theNewSchedule)->shouldBe($theNewSchedule);
    }

    public function it_can_count_scheduled_days(Period $period)
    {
        $this->scheduledDays($period)->shouldBe(0);
    }

    public function it_delegates_count_of_scheduled_days(Period $period, Schedule $delegated)
    {
        $delegated->scheduledDays($period)->willReturn(3);
        $this->chain($delegated);
        $this->scheduledDays($period)->shouldBe(3);
    }
}
