<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TicketCounter;
use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TicketCounterSpec extends ObjectBehavior
{
    public function let(TicketRepository $ticketRepository)
    {
        $this->beConstructedWith($ticketRepository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketCounter::class);
    }

    public function it_can_tell_tickets_sold_on_date(\DateTime $date, $ticketRepository)
    {
        $ticketRepository->count(Argument::type(TicketSoldOnDate::class))->shouldBeCalled()->willReturn(5);
        $this->soldOnDate($date)->shouldReturn(5);
    }

    public function it_can_set_price()
    {
        $this->setPrice(25);
        $this->getPrice()->shouldBe(25);
    }

    public function it_can_tell_income_on_date(\DateTime $date, $ticketRepository)
    {
        $ticketRepository->count(Argument::type(TicketSoldOnDate::class))->shouldBeCalled()->willReturn(5);
        $this->setPrice(25);
        $this->incomeOnDate($date)->shouldReturn(125);
    }
}
