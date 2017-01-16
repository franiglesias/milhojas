<?php

namespace spec\Milhojas\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;
use Milhojas\Library\Messaging\CommandBus\Worker\CommandWorker;
use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;
use Milhojas\Library\Messaging\CommandBus\Worker\ExecuteWorker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExecuteWorkerSpec extends ObjectBehavior
{
    public function let(Loader $loader, Inflector $inflector)
    {
        $this->beConstructedWith($loader, $inflector);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ExecuteWorker::class);
    }

    public function it_can_execute_command_calling_the_right_handler(Command $command, CommandHandler $handler, $loader, $inflector)
    {
        $inflector->inflect(get_class($command->getWrappedObject()))->shouldBeCalled()->willReturn('handlerClass');
        $loader->get('handlerClass')->shouldBeCalled()->willReturn($handler);
        $handler->handle($command)->shouldBeCalled();
        $this->work($command);
    }

    public function it_delegates_to_next_worker_in_chain(Command $command, CommandHandler $handler, CommandWorker $worker, $loader, $inflector)
    {
        $worker->execute($command)->shouldBeCalled();
        $this->chain($worker);

        $inflector->inflect(Argument::type('string'))->shouldBeCalled()->willReturn('handlerClass');
        $loader->get(Argument::type('string'))->shouldBeCalled()->willReturn($handler);
        $handler->handle($command)->shouldBeCalled();
        $this->work($command);
    }

    public function it_chains_a_worker(CommandWorker $worker)
    {
        $this->chain($worker);
    }

    public function it_chains_workers_at_the_end_of_the_chain(CommandWorker $worker, CommandWorker $worker2)
    {
        $this->chain($worker);
        $worker->chain($worker2)->shouldBeCalled();
        $this->chain($worker2);
    }
}
