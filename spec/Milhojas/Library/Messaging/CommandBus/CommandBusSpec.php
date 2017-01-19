<?php

namespace spec\Milhojas\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;

class CommandBusSpec extends ObjectBehavior
{
    public function let(Pipeline $pipeline)
    {
        $this->beConstructedWith($pipeline);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandBus::class);
    }

    public function it_dispatches_commands_through_the_pipeline(Command $command, $pipeline)
    {
        $pipeline->work($command)->shouldBeCalled();
        $this->execute($command);
    }
}
