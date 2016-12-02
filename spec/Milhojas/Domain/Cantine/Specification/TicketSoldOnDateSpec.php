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

    public function it_returns_true_if_ticket_is_in_the_same_day_but_differente_time(Ticket $ticket)
    {
        $date = new \DateTime(strtotime('11-21-2015 12:15:00'));
        $this->beConstructedWith($date);
        $ticket->getDate()->willReturn(new \DateTime(strtotime('11-21-2015 11:40:00')));
        $this->shouldBeSatisfiedBy($ticket);
    }
}
