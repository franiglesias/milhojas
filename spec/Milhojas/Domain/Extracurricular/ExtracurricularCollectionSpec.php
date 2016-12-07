<?php

namespace spec\Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\Activity;
use Milhojas\Domain\Extracurricular\ExtracurricularCollection;
use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;
use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;
use PhpSpec\ObjectBehavior;

class ExtracurricularCollectionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ExtracurricularCollection::class);
    }

    public function it_can_append_activities(Activity $activity)
    {
        $activity->getName()->willReturn('Robotics');
        $this->enrollTo($activity);
        $this->shouldBeEnrolledTo(new ActivityHasName('Robotics'));
        $this->shouldNotBeEnrolledTo(new ActivityHasName('Arts'));
    }

    public function it_can_tell_if_has_scheduled_activities(\Datetime $date, Activity $activity)
    {
        $activity->isScheduledFor($date)->willReturn(true);
        $this->enrollTo($activity);
        $this->shouldHaveScheduledActivitiesOn($date);
    }

    public function it_can_tell_if_there_is_an_activity_that_satisfied_some_specification(Activity $activity, ActivitySpecification $activitySpecification)
    {
        $activitySpecification->isSatisfiedBy($activity)->willReturn(true);
        $this->enrollTo($activity);
        $this->shouldHaveAtLeastOne($activitySpecification);
    }
}
