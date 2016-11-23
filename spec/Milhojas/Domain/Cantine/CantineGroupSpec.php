<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineGroup;
use PhpSpec\ObjectBehavior;

class CantineGroupSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Group 1');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineGroup::class);
    }

    public function it_can_tell_its_name()
    {
        $this->getName()->shouldReturn('Group 1');
    }
}
