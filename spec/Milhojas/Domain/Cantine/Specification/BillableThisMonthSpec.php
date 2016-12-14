<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\BillableThisMonth;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use Milhojas\Library\ValueObjects\Dates\MonthYear;
use PhpSpec\ObjectBehavior;

class BillableThisMonthSpec extends ObjectBehavior
{
    public function let(MonthYear $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BillableThisMonth::class);
        $this->shouldImplement(CantineUserSpecification::class);
    }
}
