<?php

namespace spec\Milhojas\Application\Cantine\Event;

use Milhojas\Application\Cantine\Event\UserWasNotAssignedToCantineTurn;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserWasNotAssignedToCantineTurnSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserWasNotAssignedToCantineTurn::class);
    }
}
