<?php

namespace spec\Milhojas\Application\Management;

use Milhojas\Application\Management\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Listener::class);
    }
}
