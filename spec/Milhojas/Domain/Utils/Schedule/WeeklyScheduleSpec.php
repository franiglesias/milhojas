<?php

namespace spec\Milhojas\Domain\Utils\Schedule;

use League\Period\Period;
use Milhojas\Domain\Utils\Schedule\Schedule;
use Milhojas\Domain\Utils\Schedule\NullSchedule;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class WeeklyScheduleSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['monday', 'wednesday', 'friday']);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(WeeklySchedule::class);
        $this->shouldImplement(Schedule::class);
    }

    public function it_can_tell_if_a_date_is_scheduled()
    {
        $this->shouldBeScheduledDate(new \DateTime('11/16/2016'));
    }

    public function it_can_tell_if_a_date_is_not_scheduled()
    {
        $this->shouldNotBeScheduledDate(new \DateTime('11/17/2016'));
    }

    public function it_can_update_schedule()
    {
        $updated = $this->update(new WeeklySchedule('tuesday'));
        $updated->shouldBeScheduledDate(new \DateTime('11/15/2016'));
    }

    public function it_only_accepts_valid_week_days()
    {
        $this->beConstructedWith(['fake']);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    public function it_can_not_update_with_a_schedule_of_another_type()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('update', [new NullSchedule()]);
    }

    public function it_can_tell_scheduled_days(Period $period)
    {
        $this->scheduledDays($period)->shouldBe(3);
    }

    public function it_can_tell_real_days(Period $period, \DateTime $date1)
    {
        $this->realDays($period)->shouldBe(3);
    }
}
