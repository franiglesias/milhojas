<?php

namespace spec\Milhojas\Application\Management\Command;

use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Application\Management\Command\StartPayrollHandler;
use Milhojas\Application\Management\Command\StartPayroll;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventRecorder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StartPayrollHandlerSpec extends ObjectBehavior
{
    public function let(PayrollProgressExchange $exchanger, EventRecorder $recorder)
    {
        $this->beConstructedWith($exchanger, $recorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(StartPayrollHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_StartPayroll_command(StartPayroll $command, $exchanger, $recorder, PayrollReporter $progress)
    {
        $exchanger->init()->shouldBeCalled();
        $command->getProgress()->shouldBeCalled()->willReturn($progress);
        $recorder->recordThat(Argument::type(PayrollDistributionStarted::class))->shouldBeCalled();
        $this->handle($command);
    }
}
