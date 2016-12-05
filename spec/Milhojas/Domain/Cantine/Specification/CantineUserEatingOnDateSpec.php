<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class CantineUserEatingOnDateSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserEatingOnDate::class);
        $this->shouldImplement(CantineUserSpecification::class);
    }

    public function it_should_be_satisfied_by_users_eating_on_schedule(CantineUser $user, $date)
    {
        $user->isEatingOnDate($date)->shouldBeCalled()->willReturn(true);
        $this->shouldBeSatisfiedBy($user);
    }

    public function it_should_not_be_satisfied_by_users_not_eating_on_schedule(CantineUser $user, $date)
    {
        $user->isEatingOnDate($date)->shouldBeCalled()->willReturn(false);
        $this->shouldNotBeSatisfiedBy($user);
    }
}
