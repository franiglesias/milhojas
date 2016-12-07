<?php

namespace spec\Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\Specification\ActivityScheduledOn;
use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;
use Milhojas\Domain\Extracurricular\Activity;
use PhpSpec\ObjectBehavior;

class ActivityScheduledOnSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(ActivityScheduledOn::class);
        $this->shouldImplement(ActivitySpecification::class);
    }

    public function it_should_be_satisfied_by_activity(Activity $activity, $date)
    {
        $activity->isScheduledFor($date)->willReturn(true);
        $this->shouldBeSatisfiedBy($activity);
    }

    public function it_should_not_be_satisfied_by_activity(Activity $activity, $date)
    {
        $activity->isScheduledFor($date)->willReturn(false);
        $this->shouldNotBeSatisfiedBy($activity);
    }
}
