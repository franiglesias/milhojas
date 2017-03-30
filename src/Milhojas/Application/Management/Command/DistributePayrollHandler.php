<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\Staff;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandBus;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventBus;


/**
 * Distributes payroll documents for a month.
 */
class DistributePayrollHandler implements CommandHandler
{
    /**
     * To execute the command to send the payroll
     * @var CommandBus
     */
    private $bus;
    /**
     * THe collection of employees
     * @var Staff
     */
    private $staff;
    /**
     * To dispatch events
     * @var EventBus
     */
    private $eventDispatcher;
    /**
     * Access to payrolls
     * @var Payrolls
     */
    private $payrolls;


    /**
     * DistributePayrollHandler constructor.
     *
     * @param Staff             $staff
     * @param Payrolls          $payrolls
     * @param                   $bus
     * @param                   $eventDispatcher
     */
    public function __construct(Staff $staff, Payrolls $payrolls, CommandBus $bus, EventBus $eventDispatcher)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->eventDispatcher = $eventDispatcher;
        $this->payrolls = $payrolls;
    }

    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $progress = new PayrollReporter(0, $this->staff->countAll());
        $this->payrolls->loadMonthDataFrom($command->getMonth(), $command->getPaths());
        $this->eventDispatcher->dispatch(new PayrollDistributionStarted($progress));

        foreach ($this->staff as $employee) {
            $progress = $progress->advance();
            $this->bus->execute(new SendPayroll($employee, $command->getMonth(), $progress));
        }

        $this->eventDispatcher->dispatch(new AllPayrollsWereSent($progress, $command->getMonth()));
    }

}
