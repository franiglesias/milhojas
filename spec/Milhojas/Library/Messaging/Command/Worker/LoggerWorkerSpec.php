<?php

namespace spec\Milhojas\Library\Messaging\Command\Worker;

use Milhojas\Library\Messaging\Command\Worker\LoggerWorker;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Worker\CommandWorker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class LoggerWorkerSpec extends ObjectBehavior
{
    public function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(LoggerWorker::class);
        $this->shouldBeAnInstanceOf(CommandWorker::class);
    }

    public function it_logs_current_command(Command $command, $logger)
    {
        $logger->notice(Argument::containingString('has been launched.'))->shouldBeCalled();
        $this->execute($command);
    }
}
