<?php

namespace spec\Milhojas\Application\Cantine\Listener;

use Milhojas\Application\Cantine\Listener\RegisterBoughtTickets;
use Milhojas\Domain\Cantine\Event\CantineUserBoughtTickets;
use Milhojas\Domain\Cantine\TicketRegistrar;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Messaging\EventBus\Listener;
use PhpSpec\ObjectBehavior;

class RegisterBoughtTicketsSpec extends ObjectBehavior
{
    public function let(TicketRegistrar $registrar)
    {
        $this->beConstructedWith($registrar);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterBoughtTickets::class);
        $this->shouldImplement(Listener::class);
    }

    public function it_handles_the_event_and_registers_bought_tickets(CantineUserBoughtTickets $event, CantineUser $user, ListOfDates $dates, $registrar)
    {
        $registrar->register($user, $dates)->shouldBeCalled();
        $event->getUser()->willReturn($user);
        $event->getDates()->willReturn($dates);
        $this->handle($event->getWrappedObject());
    }
}
