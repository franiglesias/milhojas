<?php

namespace spec\Milhojas\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Workers\CommandWorker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandBusSpec extends ObjectBehavior
{
    public function let(CommandWorker $worker1, CommandWorker $worker2, CommandWorker $worker3)
    {
        $worker1->setNext($worker2)->shouldBeCalled();
        $worker2->setNext($worker3)->shouldBeCalled();
        $worker3->setNext(Argument::any())->shouldNotBeCalled();
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
