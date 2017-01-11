<?php

namespace spec\Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\Event\CantineUserBoughtTickets;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\Messaging\EventBus\Event;
use PhpSpec\ObjectBehavior;

class CantineUserBoughtTicketsSpec extends ObjectBehavior
{
    public function let(CantineUser $user, ListOfDates $dates)
    {
        $this->beConstructedWith($user, $dates);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserBoughtTickets::class);
        $this->shouldImplement(Event::class);
    }

    public function it_has_the_right_name()
    {
        $this->getName()->shouldBe('milhojas.cantine.cantine_user_bought_tickets');
    }

    public function it_can_get_user_and_dates(CantineUser $user, ListOfDates $dates)
    {
        $this->getUser()->shouldBe($user);
        $this->getDates()->shouldBe($dates);
    }
}
