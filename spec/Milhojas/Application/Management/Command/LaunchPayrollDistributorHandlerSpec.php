<?php

namespace spec\Milhojas\Application\Management\Command;

use Milhojas\Application\Management\Command\LaunchPayrollDistributor;
use Milhojas\Application\Management\Command\LaunchPayrollDistributorHandler;
use Milhojas\Application\Management\PayrollDistributor;
use Milhojas\Infrastructure\Process\CommandLineBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class LaunchPayrollDistributorHandlerSpec extends ObjectBehavior
{

    public function let(CommandLineBuilder $clibuilder)
    {
        $this->beConstructedWith($clibuilder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(LaunchPayrollDistributorHandler::class);
    }

    public function it_handles_LaunchPayrollDistributor_command(
        LaunchPayrollDistributor $command,
        PayrollDistributor $distributor,
        CommandLineBuilder $clibuilder
    ) {
        $clibuilder->setCommand('payroll:month')->willReturn($clibuilder);
        $clibuilder->withArgument(Argument::any())->willReturn($clibuilder);
        $clibuilder->outputTo(Argument::any())->willReturn($clibuilder);
        $clibuilder->environment(Argument::any())->willReturn($clibuilder);
        $clibuilder->setWorkingDirectory(Argument::any())->willReturn($clibuilder);
        $clibuilder->start()->shouldBeCalled();

        $command->getEnvironment()->shouldBeCalled()->willReturn('dev');
        $command->getRootPath()->shouldBeCalled()->willReturn('path');
        $command->getLogfile()->shouldBeCalled()->willReturn('var/logs/afile.log');
        $command->getMonth()->shouldBeCalled();
        $command->getYear()->shouldBeCalled();
        $command->getFileName()->shouldBeCalled()->willReturn([]);

        $this->handle($command);
    }
}
