<?php

namespace spec\Milhojas\Application\Cantine\Query;

use Milhojas\Application\Cantine\Query\GetCantineAttendancesListFor;
use Milhojas\Application\Cantine\Query\GetCantineAttendancesListForHandler;
use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Domain\Cantine\CantineUserRepository;
use Milhojas\Domain\Cantine\Assigner;
use Milhojas\Domain\Cantine\Specification\CantineUserEatingOnDate;
use Milhojas\Library\Messaging\QueryBus\QueryHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetCantineAttendancesListForHandlerSpec extends ObjectBehavior
{
    public function let(CantineUserRepository $repository, Assigner $assigner)
    {
        $this->beConstructedWith($repository, $assigner);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(GetCantineAttendancesListForHandler::class);
        $this->shouldImplement(QueryHandler::class);
    }

    public function it_can_manage_the_query(GetCantineAttendancesListFor $query, \DateTime $date, CantineList $list, $repository, $assigner)
    {
        $repository->find(Argument::type(CantineUserEatingOnDate::class))->shouldBeCalled();
        $assigner->assign($date, Argument::any())->shouldBeCalled()->willReturn($list);
        $query->getDate()->willReturn($date);
        $this->answer($query)->shouldHaveType(CantineList::class);
    }
}
