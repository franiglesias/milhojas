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
}
