<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\Specification\TicketSoldToStudent;
use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Shared\StudentId;
use PhpSpec\ObjectBehavior;

class TicketSoldToStudentSpec extends ObjectBehavior
{
    public function let(StudentId $studentId)
    {
        $this->beConstructedWith($studentId);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketSoldToStudent::class);
        $this->shouldBeAnInstanceOf(TicketSpecification::class);
    }

    public function it_is_satisfied_by_tickets(Ticket $ticket, $studentId, StudentId $another)
    {
        $ticket->getUserId()->willReturn($studentId);
        $this->shouldBeSatisfiedBy($ticket);

        $ticket->getUserId()->willReturn($another);
        $this->shouldNotBeSatisfiedBy($ticket);
    }
}
