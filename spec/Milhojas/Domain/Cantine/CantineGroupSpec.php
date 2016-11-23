<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineGroup;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CantineGroupSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CantineGroup::class);
    }
}
