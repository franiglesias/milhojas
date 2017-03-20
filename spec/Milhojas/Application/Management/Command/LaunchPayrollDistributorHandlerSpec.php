<?php

namespace spec\Milhojas\Application\Management\Command;

use Milhojas\Application\Management\Command\LaunchPayrollDistributorHandler;
use Milhojas\Application\Management\Command\LaunchPayrollDistributor;
use Milhojas\Application\Management\PayrollDistributor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class LaunchPayrollDistributorHandlerSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType(LaunchPayrollDistributorHandler::class);
    }

    public function it_handles_LaunchPayrollDistributor_command(
        LaunchPayrollDistributor $command,
        PayrollDistributor $distributor
    ) {
        $command->getDistribution()->shouldBeCalled()->willReturn($distributor);
        $command->getEnvironment()->shouldBeCalled()->willReturn('dev');
        $command->getRootPath()->shouldBeCalled()->willReturn('path');
        $command->getLogfile()->shouldBeCalled()->willReturn('var/logs/afile.log');
        $distributor->getMonthString()->shouldBeCalled();
        $distributor->getYear()->shouldBeCalled();
        $distributor->getFileName()->shouldBeCalled()->willReturn([]);
        $this->handle($command);
    }
}
