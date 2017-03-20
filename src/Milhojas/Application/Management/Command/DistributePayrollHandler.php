<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
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
    private $eventDispatcher;

    public function __construct(Staff $staff, $sender, $bus, $eventDispatcher)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->sender = $sender;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(Command $command)
    {
        $progress = new PayrollReporter(0, $this->staff->countAll());

        $this->eventDispatcher->dispatch(new PayrollDistributionStarted($progress));

        foreach ($this->staff as $employee) {
            $progress = $progress->advance();
            $this->bus->execute(new SendPayroll($employee, $command->getMonth(), $command->getPaths(), $this->sender, $progress));
        }

        $this->eventDispatcher->dispatch(new AllPayrollsWereSent($progress, $command->getMonth()));
    }
}
