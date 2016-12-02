<?php

namespace spec\Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Infrastructure\Persistence\Cantine\TicketInMemoryRepository;
use PhpSpec\ObjectBehavior;

class TicketInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketInMemoryRepository::class);
        $this->shouldImplement(TicketRepository::class);
    }

    public function it_can_store_tickets(Ticket $ticket)
    {
        $this->store($ticket);
    }

    public function it_can_count_stored_tickets_satisfiying_a_condition(TicketSpecification $ticketSpecification, Ticket $ticket1, Ticket $ticket2)
    {
        $this->store($ticket1);
        $this->store($ticket2);
        $ticketSpecification->isSatisfiedBy($ticket1)->shouldBeCalled()->willReturn(true);
        $ticketSpecification->isSatisfiedBy($ticket2)->shouldBeCalled()->willReturn(false);
        $this->countSatisfying($ticketSpecification)->shouldBeInteger();
        $this->countSatisfying($ticketSpecification)->shouldReturn(1);
    }
}
