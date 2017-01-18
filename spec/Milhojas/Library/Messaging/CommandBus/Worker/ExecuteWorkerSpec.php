<?php

namespace spec\Milhojas\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;
use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;
use Milhojas\Library\Messaging\CommandBus\Worker\ExecuteWorker;
use PhpSpec\ObjectBehavior;

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
}
