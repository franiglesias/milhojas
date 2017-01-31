<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\PayrollReporter;

// Application Messaging infrastructure

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;

// Events

/**
 * Distributes payroll documents for a month.
 */
class DistributePayrollHandler implements CommandHandler
{
    private $bus;
    private $sender;
    private $staff;
    private $logger;

    public function __construct(Staff $staff, $sender, $bus, $logger)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->sender = $sender;
        $this->logger = $logger;
    }

    public function handle(Command $command)
    {
        $progress = new PayrollReporter(0, $this->staff->countAll());
        $this->logger->notice('Start Payroll command about to be launched');
        $this->bus->execute(new StartPayroll($progress));
        $this->logger->notice('Start Payroll command launched');
        foreach ($this->staff as $employee) {
            $progress = $progress->advance();
            $this->logger->notice('SendPayroll command about to be launched');
            $this->bus->execute(new SendPayroll($employee, $command->getMonth(), $command->getPaths(), $this->sender, $progress));
            $this->logger->notice('SendPayroll launched');
        }

        $this->bus->execute(new EndPayroll($command->getMonth(), $progress));
    }
}
