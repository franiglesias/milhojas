<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Factories\TurnsFactory;
use Milhojas\Domain\Cantine\Turn;
use PhpSpec\ObjectBehavior;

class TurnsFactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
        $this->configure(['Turno 1', 'Turno 2', 'Turno 3']);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(TurnsFactory::class);
    }

    public function it_can_give_turns_by_name()
    {
        $this->getTurn('Turno 1')->shouldHaveType(Turn::class);
    }

    public function it_can_give_all_turns()
    {
        $this->getTurns()->shouldBeArray();
        $this->getTurns()->shouldHaveCount(3);
    }
}
