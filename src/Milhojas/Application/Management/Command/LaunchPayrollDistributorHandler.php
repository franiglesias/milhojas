<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Infrastructure\Process\CommandLineBuilder;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;


class LaunchPayrollDistributorHandler implements CommandHandler
{
    /**
     * @var CommandLineBuilder
     */
    private $cliBuilder;

    /**
     * LaunchPayrollDistributorHandler constructor.
     *
     * @param CommandLineBuilder $cliBuilder
     */
    public function __construct(CommandLineBuilder $cliBuilder)
    {
        $this->cliBuilder = $cliBuilder;
    }


    public function handle(Command $command)
    {
        $cli = $this->cliBuilder->setCommand('payroll:month')
            ->withArgument($command->getMonth())
            ->withArgument($command->getYear())
            ->withArgument(implode(' ', $command->getFileName()))
            ->outputTo($command->getLogfile())
            ->environment($command->getEnvironment())
            ->setWorkingDirectory($command->getRootPath())
        ;

        $cli->start();
    }
}
