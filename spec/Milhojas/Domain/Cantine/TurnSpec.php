<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Turn;
use Milhojas\Library\Sortable\Sortable;
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
        $this->shouldImplement(Sortable::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBe('Turn 1');
    }

    public function it_can_compare_with_others()
    {
        $this->compare(new Turn('Turn 2', 2))->shouldBe(Sortable::SMALLER);
        $this->compare(new Turn('Turn 0', 0))->shouldBe(Sortable::GREATER);
        $this->compare(new Turn('Turn 1', 1))->shouldBe(Sortable::EQUAL);
    }
}
