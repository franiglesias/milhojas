<?php

namespace spec\Milhojas\Domain\Extracurricular\Specification;

use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;
use Milhojas\Domain\Extracurricular\Specification\ActivitySpecification;
use Milhojas\Domain\Extracurricular\Activity;
use PhpSpec\ObjectBehavior;

class ActivityHasNameSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Robotics');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(ActivityHasName::class);
        $this->shouldImplement(ActivitySpecification::class);
    }

    public function it_should_be_satisfyed_by_activity_with_name(Activity $activity)
    {
        $activity->getName()->shouldBeCalled()->willReturn('Robotics');
        $this->shouldBeSatisfiedBy($activity);
    }

    public function it_should_not_be_satisfyed_by_activity_with_name(Activity $activity)
    {
        $activity->getName()->shouldBeCalled()->willReturn('Arts');
        $this->shouldNotBeSatisfiedBy($activity);
    }
}
