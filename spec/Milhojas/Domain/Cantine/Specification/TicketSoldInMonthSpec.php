<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use League\Period\Period;
use Milhojas\Domain\Cantine\Specification\TicketSoldInMonth;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\Ticket;
use PhpSpec\ObjectBehavior;

class TicketSoldInMonthSpec extends ObjectBehavior
{
    public function let(Period $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketSoldInMonth::class);
        $this->shouldBeAnInstanceOf(TicketSpecification::class);
    }

    public function it_should_be_satisfyed_by_a_date_in_the_month(Ticket $ticket, $month)
    {
        $ticket->belongsToPeriod($month)->willReturn(true);
        $this->shouldBeSatisfiedBy($ticket);
    }

    public function it_should_not_be_satisfyed_by_a_date_not_in_the_month(Ticket $ticket, $month)
    {
        $ticket->belongsToPeriod($month)->willReturn(false);
        $this->shouldNotBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_paid(Ticket $ticket, $month)
    {
        $ticket->isPaid()->willReturn(true);
        $ticket->belongsToPeriod($month)->willReturn(true);
        $this->onlyPaid()->shouldBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_paid_excluding_pending(Ticket $ticket, $month)
    {
        $ticket->isPaid()->willReturn(false);
        $ticket->belongsToPeriod($month)->willReturn(true);
        $this->onlyPaid()->shouldNotBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_pending(Ticket $ticket, $month)
    {
        $ticket->isPaid()->willReturn(false);
        $ticket->belongsToPeriod($month)->willReturn(true);
        $this->onlyPending()->shouldBeSatisfiedBy($ticket);
    }

    public function it_can_filter_only_pending_excluding_paid(Ticket $ticket, $month)
    {
        $ticket->isPaid()->willReturn(true);
        $ticket->belongsToPeriod($month)->willReturn(true);
        $this->onlyPending()->shouldNotBeSatisfiedBy($ticket);
    }
}
