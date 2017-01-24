<?php

namespace spec\Milhojas\Application\Management\Command;

use League\Flysystem\FilesystemInterface;
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
    public function let(FilesystemInterface $fs, EventRecorder $recorder)
    {
        $this->beConstructedWith('management-payroll-reporter.json', $fs, $recorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(EndPayrollHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_EndPayroll_command(EndPayroll $command, $fs, $recorder, AllPayrollsWereSent $event, PayrollReporter $progress, PayrollMonth $month)
    {
        $command->getMonth()->shouldBeCalled()->willReturn($month);
        $command->getProgress()->shouldBeCalled()->willReturn($progress);
        $fs->delete('management-payroll-reporter.json')->shouldBeCalled();
        $recorder->recordThat(Argument::type(AllPayrollsWereSent::class))->shouldBeCalled();
        $this->handle($command);
    }
}
