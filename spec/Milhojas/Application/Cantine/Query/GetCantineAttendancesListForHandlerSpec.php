<?php

namespace spec\Milhojas\Application\Cantine\Query;

use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListForHandler;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineList\CantineSeatRepository;
use Milhojas\Domain\Cantine\Specification\CantineSeatForDate;
use Milhojas\Messaging\QueryBus\QueryHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetCantineAttendancesListForHandlerSpec extends ObjectBehavior
{
    public function let(CantineSeatRepository $repository)
    {
        $this->beConstructedWith($repository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetCantineAttendancesListForHandler::class);
        $this->shouldImplement(QueryHandler::class);
    }

    public function it_can_manage_the_query(GetCantineAttendancesListFor $query, \DateTime $date, CantineList $list, $repository)
    {
        $repository->find(Argument::type(CantineSeatForDate::class))->shouldBeCalled()->willReturn($list);

        $query->getDate()->willReturn($date);

        $this->answer($query)->shouldHaveType(CantineList::class);
    }
}
