<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TicketCounter;
use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;
use Milhojas\Domain\Cantine\Specification\TicketSoldInMonth;
use PhpSpec\ObjectBehavior;

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

    public function it_can_count_tickets_sold_on_date(\DateTime $date, $ticketRepository, TicketSoldOnDate $ticketSoldOnDate)
    {
        $ticketRepository->count($ticketSoldOnDate)->shouldBeCalled()->willReturn(5);
        $this->count($ticketSoldOnDate)->shouldBe(5);
    }

    public function it_can_count_tickets_sold_in_months(\DateTime $date, $ticketRepository, TicketSoldInMonth $ticketSoldInMonth)
    {
        $ticketRepository->count($ticketSoldInMonth)->shouldBeCalled()->willReturn(5);
        $this->count($ticketSoldInMonth)->shouldBe(5);
    }

    public function it_can_set_price()
    {
        $this->setPrice(25);
        $this->getPrice()->shouldBe(25);
    }

    public function it_can_tell_income_on_date(\DateTime $date, $ticketRepository, TicketSoldOnDate $ticketSoldOnDate)
    {
        $ticketRepository->count($ticketSoldOnDate)->shouldBeCalled()->willReturn(5);
        $this->setPrice(25);
        $this->income($ticketSoldOnDate)->shouldReturn(125);
    }
}
