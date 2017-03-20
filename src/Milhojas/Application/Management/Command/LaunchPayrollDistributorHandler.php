<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Infrastructure\Process\CommandLineBuilder;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;


class LaunchPayrollDistributorHandler implements CommandHandler
{
    public function handle(Command $command)
    {
        $distribution = $command->getDistribution();

        $cli = (new CommandLineBuilder('payroll:month'))
            ->withArgument($distribution->getMonthString())
            ->withArgument($distribution->getYear())
            ->withArgument(implode(' ', $distribution->getFileName()))
            ->outputTo($command->getLogfile())
            ->environment($command->getEnvironment())
            ->setWorkingDirectory($command->getRootPath())
        ;

        $cli->start();
    }
}
