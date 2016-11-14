<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CantineRuleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CantineRule::class);
    }
}
