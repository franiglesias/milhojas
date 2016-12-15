<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Cantine\CantineUser;
use League\Period\Period;
use PhpSpec\ObjectBehavior;

class TicketSpec extends ObjectBehavior
{
    public function let(CantineUser $user, \DateTimeImmutable $date)
    {
        $this->beConstructedWith($user, $date);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Ticket::class);
    }

    public function it_can_tell_date(\DateTimeImmutable $date)
    {
        $this->getDate()->shouldBe($date);
    }

    public function it_can_tell_user($user)
    {
        $this->getUser()->shouldBe($user);
    }

    public function it_can_tell_about_paying_state()
    {
        $this->shouldNotBePaid();
    }

    public function it_can_be_paid()
    {
        $this->pay();
        $this->shouldBePaid();
    }

    public function it_can_tell_ticket_belongs_to_a_period($user, Period $period)
    {
        $this->beConstructedWith($user, new \DateTime('11/25/2016'));
        $this->belongsToPeriod(Period::createFromMonth('2016', '11'))->shouldBe(true);
    }
}
