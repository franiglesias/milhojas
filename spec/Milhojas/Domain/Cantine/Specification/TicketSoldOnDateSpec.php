<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\Ticket;
use PhpSpec\ObjectBehavior;

class TicketSoldOnDateSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketSoldOnDate::class);
        $this->shouldImplement(TicketSpecification::class);
    }

    public function it_returns_true_if_ticket_is_in_the_same_day_even_at_different_time(Ticket $ticket)
    {
        $this->beConstructedWith(new \DateTime('11/21/2016 12:15'));
        $ticket->getDate()->willReturn(new \DateTime('11/21/2016 16:40'));
        $this->shouldBeSatisfiedBy($ticket);
    }
}
