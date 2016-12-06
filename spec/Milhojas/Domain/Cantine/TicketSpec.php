<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Cantine\CantineUser;
use PhpSpec\ObjectBehavior;

class TicketSpec extends ObjectBehavior
{
    public function let(CantineUser $user, \DateTime $date)
    {
        $this->beConstructedWith($user, $date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Ticket::class);
    }

    public function it_can_tell_date(\DateTime $date)
    {
        $this->getDate()->shouldBe($date);
    }

    public function it_can_tell_user($user)
    {
        $this->getUser()->shouldBe($user);
    }

    public function it_can_tell_ticket_belongs_to_a_month(CantineUser $user)
    {
        $this->beConstructedWith($user, new \DateTime('11/25/2016'));
        $this->belongsToMonth('November')->shouldBe(true);
    }
}
