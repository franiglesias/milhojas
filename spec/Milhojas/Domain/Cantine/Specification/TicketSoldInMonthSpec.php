<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\TicketSoldInMonth;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Library\ValueObjects\Dates\MonthYear;
use PhpSpec\ObjectBehavior;

class TicketSoldInMonthSpec extends ObjectBehavior
{
    public function let(MonthYear $month)
    {
        $this->beConstructedWith($month);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketSoldInMonth::class);
        $this->shouldImplement(TicketSpecification::class);
    }

    public function it_should_be_satisfyed_by_a_date_in_the_month(Ticket $ticket, $month)
    {
        $ticket->belongsToMonth($month)->willReturn(true);
        $this->shouldBeSatisfiedBy($ticket);
    }

    public function it_should_not_be_satisfyed_by_a_date_not_in_the_month(Ticket $ticket, $month)
    {
        $ticket->belongsToMonth($month)->willReturn(false);
        $this->shouldNotBeSatisfiedBy($ticket);
    }
}
