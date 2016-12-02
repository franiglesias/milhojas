<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Ticket;
use PhpSpec\ObjectBehavior;

class TicketSpec extends ObjectBehavior
{
    public function let(\DateTime $date)
    {
        $this->beConstructedWith($date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Ticket::class);
    }

    public function it_can_tell_date(\DateTime $date)
    {
        $this->getDate()->shouldBe($date);
    }
}
