<?php

namespace spec\Milhojas\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;

class CommandBusSpec extends ObjectBehavior
{
    public function let(MessageWorker $worker1, MessageWorker $worker2, MessageWorker $worker3)
    {
        $worker1->chain($worker2)->shouldBeCalled();
        $worker1->chain($worker3)->shouldBeCalled();
        $this->beConstructedWith([$worker1, $worker2, $worker3]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandBus::class);
    }

    public function it_executes_a_command_passing_it_to_all_workers_in_order(Command $command, $worker1, $worker2, $worker3)
    {
        $worker1->execute($command)->shouldBeCalled();
        $this->execute($command);
    }
}
