<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\NullCantineGroup;
use PhpSpec\ObjectBehavior;

class NullCantineGroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NullCantineGroup::class);
        $this->shouldHaveType(CantineGroup::class);
    }

    public function its_name_is_Not_Assigned()
    {
        $this->getName()->shouldBe('Not Assigned');
    }
}
