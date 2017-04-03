<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 3/4/17
 * Time: 12:12
 */

namespace Tests\Application\Management\Command;

use Milhojas\Application\Management\Command\LaunchPayrollDistributor;
use Milhojas\Application\Management\Command\LaunchPayrollDistributorHandler;
use Milhojas\Application\Management\PayrollDistributionEnvironment;
use Milhojas\Application\Management\PayrollDistributor;
use Milhojas\Infrastructure\Process\CommandLineBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;


class LaunchPayrollDistributorHandlerTest extends TestCase
{

    public function test_it_handles_the_command_paas_data_to_build_cli()
    {
        $environment = $this->prophesize(PayrollDistributionEnvironment::class);

        $distributor = $this->prophesize(PayrollDistributor::class);
        $distributor->getMonthString()->willReturn('03');
        $distributor->getYear()->willReturn('2017');
        $distributor->getFileName()->willReturn(['filename.zip']);


        $clibuilder = $this->prophesize(CommandLineBuilder::class);
        $clibuilder->setCommand('payroll:month')->willReturn($clibuilder);
        $clibuilder->withArgument(Argument::any())->willReturn($clibuilder);
        $clibuilder->outputTo(Argument::any())->willReturn($clibuilder);
        $clibuilder->environment(Argument::any())->willReturn($clibuilder);
        $clibuilder->setWorkingDirectory(Argument::any())->willReturn($clibuilder);
        $clibuilder->start()->shouldBeCalled();
        $handler = new LaunchPayrollDistributorHandler($clibuilder->reveal());
        $command = new LaunchPayrollDistributor($distributor->reveal(), $environment->reveal());

        $handler->handle($command);

        $clibuilder->setCommand('payroll:month')->shouldHaveBeenCalled();
        $clibuilder->start()->shouldHaveBeenCalled();

        $distributor->getMonthString()->shouldHaveBeenCalled();
        $distributor->getYear()->shouldHaveBeenCalled();
        $distributor->getFileName()->shouldHaveBeenCalled();

        $environment->getLogfile()->shouldHaveBeenCalled();
        $environment->getEnvironment()->shouldHaveBeenCalled();
        $environment->getRootPath()->shouldHaveBeenCalled();
    }
}
