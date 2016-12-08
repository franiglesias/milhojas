<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\Ticket;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TicketSoldOnDateSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $date->format('%d')->willReturn(0);
        $date->diff(Argument::type(\DateTime::class))->willReturn($date);
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketSoldOnDate::class);
        $this->shouldBeAnInstanceOf(TicketSpecification::class);
    }

    public function it_returns_true_if_ticket_is_in_the_same_day_even_at_different_time(Ticket $ticket)
    {
        $this->beConstructedWith(new \DateTime('11/21/2016 12:15'));
        $ticket->getDate()->willReturn(new \DateTime('11/21/2016 16:40'));
        $this->shouldBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_paid(Ticket $ticket, \DateTime $date)
    {
        $ticket->isPaid()->willReturn(true);
        $ticket->getDate()->willReturn($date);
        $this->onlyPaid()->shouldBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_paid_excluding_pending(Ticket $ticket, \DateTime $date)
    {
        $ticket->isPaid()->willReturn(false);
        $ticket->getDate()->willReturn($date);
        $this->onlyPaid()->shouldNotBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_pending(Ticket $ticket, \DateTime $date)
    {
        $ticket->isPaid()->willReturn(false);
        $ticket->getDate()->willReturn($date);
        $this->onlyPending()->shouldBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_pending_excluding_paid(Ticket $ticket, \DateTime $date)
    {
        $ticket->isPaid()->willReturn(true);
        $ticket->getDate()->willReturn($date);
        $this->onlyPending()->shouldNotBeSatisfiedBy($ticket);
    }
}
