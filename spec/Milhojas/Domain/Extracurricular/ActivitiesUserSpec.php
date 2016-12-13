<?php

namespace spec\Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Activity;
use Milhojas\Domain\Extracurricular\ActivitiesUser;
use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;
use PhpSpec\ObjectBehavior;

class ActivitiesUserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ActivitiesUser::class);
    }

    public function it_can_enroll_activities(Activity $activity)
    {
        $activity->getName()->willReturn('Robotics');
        $this->enrollTo($activity);
        $this->shouldBeEnrolledTo(new ActivityHasName('Robotics'));
        $this->shouldNotBeEnrolledTo(new ActivityHasName('Arts'));
    }

    public function it_can_disenroll_from_activtiy(Activity $activity)
    {
        $activity->getName()->willReturn('Robotics');
        $this->enrollTo($activity);
        $this->disenrollFrom($activity);
        $this->shouldNotBeEnrolledTo(new ActivityHasName('Robotics'));
    }

    public function it_can_tell_if_has_scheduled_activities(\DateTimeImmutable $date, Activity $activity)
    {
        $activity->isScheduledFor($date)->willReturn(true);
        $this->enrollTo($activity);
        $this->shouldHaveScheduledActivitiesOn($date);
    }
}
