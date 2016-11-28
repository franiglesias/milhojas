<?php

namespace spec\Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Extracurricular;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class ExtracurricularSpec extends ObjectBehavior
{
    public function let(WeeklySchedule $weeklySchedule)
    {
        $this->beConstructedWith('dance', $weeklySchedule);
    }
    public function it_is_initializable_with_name_and_schedule()
    {
        $this->shouldHaveType(Extracurricular::class);
        $this->getName()->shouldReturn('dance');
    }

    public function it_can_tell_if_runs_on_date(\DateTime $someDay, WeeklySchedule $weeklySchedule)
    {
        $weeklySchedule->isScheduledDate($someDay)->willReturn(true);
        $this->runsOnDate($someDay)->shouldReturn(true);
    }
}
