<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\NullTurn;
use Milhojas\Domain\Cantine\Turn;
use PhpSpec\ObjectBehavior;

class NullTurnSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NullTurn::class);
        $this->shouldBeAnInstanceOf(Turn::class);
    }

    public function its_name_is_not_assigned()
    {
        $this->getName()->shouldBe('Not assigned');
    }
}
