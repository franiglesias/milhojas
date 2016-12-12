<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use PhpSpec\ObjectBehavior;

class TurnSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Turn 1', 1);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Turn::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBe('Turn 1');
    }

    public function it_can_compare_with_others()
    {
        $this->shouldBeLessThan(new Turn('Turn 2', 2));
    }
}
