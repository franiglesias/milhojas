<?php

namespace spec\Milhojas\Application\Management\Command;

use Milhojas\Application\Management\Command\EndPayrollHandler;
use Milhojas\Application\Management\Command\EndPayroll;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventRecorder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EndPayrollHandlerSpec extends ObjectBehavior
{
    public function let(EventRecorder $recorder)
    {
        $this->beConstructedWith($recorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(EndPayrollHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_EndPayroll_command(EndPayroll $command, $recorder, AllPayrollsWereSent $event, PayrollReporter $progress, PayrollMonth $month)
    {
        $command->getMonth()->shouldBeCalled()->willReturn($month);
        $command->getProgress()->shouldBeCalled()->willReturn($progress);
        $recorder->recordThat(Argument::type(AllPayrollsWereSent::class))->shouldBeCalled();
        $this->handle($command);
    }
}
