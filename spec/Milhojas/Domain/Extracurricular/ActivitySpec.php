<?php

namespace spec\Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Activity;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use PhpSpec\ObjectBehavior;

class ActivitySpec extends ObjectBehavior
{
    public function let(WeeklySchedule $weeklySchedule)
    {
        $this->beConstructedThrough('createFrom', ['Robotics', 'morning', $weeklySchedule]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Activity::class);
    }

    public function it_can_tell_its_name()
    {
        $this->getName()->shouldBe('Robotics');
    }
}
