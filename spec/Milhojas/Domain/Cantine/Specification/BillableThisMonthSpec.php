<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use League\Period\Period;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\Specification\BillableThisMonth;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use PhpSpec\ObjectBehavior;

class BillableThisMonthSpec extends ObjectBehavior
{
    public function let(Period $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BillableThisMonth::class);
        $this->shouldImplement(CantineUserSpecification::class);
    }
    public function it_is_satisfied_by_a_cantine_user(CantineUser $cantineUser, $month)
    {
        $cantineUser->isBillableOn($month)->willReturn(true);
        $this->shouldBeSatisfiedBy($cantineUser);
        $cantineUser->isBillableOn($month)->willReturn(false);
        $this->shouldNotBeSatisfiedBy($cantineUser);
    }
}
