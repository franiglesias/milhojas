<?php

namespace spec\Milhojas\Application\Cantine\Query;

use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Milhojas\Library\QueryBus\Query;
use PhpSpec\ObjectBehavior;

class GetCantineAttendancesListForSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetCantineAttendancesListFor::class);
        $this->shouldImplement(Query::class);
    }

    public function it_can_provide_the_date($date)
    {
        $this->getDate()->shouldBe($date);
    }
}
