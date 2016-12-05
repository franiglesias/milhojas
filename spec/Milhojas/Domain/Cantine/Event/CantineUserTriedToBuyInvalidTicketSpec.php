<?php

namespace spec\Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\Event\CantineUserTriedToBuyInvalidTicket;
use PhpSpec\ObjectBehavior;

class CantineUserTriedToBuyInvalidTicketSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserTriedToBuyInvalidTicket::class);
    }
}
