<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\TicketCounter;
use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Cantine\DTO\TicketCountResult;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
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

    public function it_can_set_price()
    {
        $this->setPrice(25);
        $this->getPrice()->shouldBe(25);
    }

    public function it_counts_tickets_on_period($ticketRepository, TicketSpecification $allTickets, TicketSpecification $onlyPaidTickets)
    {
        $allTickets->all()->willReturn($allTickets);
        $allTickets->onlyPaid()->willReturn($onlyPaidTickets);

        $ticketRepository->count($allTickets)->willReturn(100);
        $ticketRepository->count($onlyPaidTickets)->willReturn(70);

        $expected = new TicketCountResult(25, 70, 100);

        $this->setPrice(25);
        $this->count($allTickets)->shouldHaveType(TicketCountResult::class);
        $this->count($allTickets)->shouldBeLike($expected);
    }
}
