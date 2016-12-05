<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\TicketRegistrar;
use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TicketRegistrarSpec extends ObjectBehavior
{
    public function let(TicketRepository $repository)
    {
        $this->beConstructedWith($repository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketRegistrar::class);
    }

    public function it_stores_tickets_into_repository($repository, CantineUser $cantineUser)
    {
        $list = new ListOfDates([
            new \DateTime(),
            new \DateTime(),
        ]);
        $repository->store(Argument::any())->shouldBeCalled();
        $this->register($cantineUser, $list);
    }
}
