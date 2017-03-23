<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\Staff;
use Milhojas\Infrastructure\FileSystem\FileSystemFactory;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;


// Application Messaging infrastructure

// Events

/**
 * Distributes payroll documents for a month.
 */
class DistributePayrollHandler implements CommandHandler
{
    private $bus;
    private $staff;
    private $eventDispatcher;
    /**
     * @var Payrolls
     */
    private $payrolls;
    /**
     * @var
     */
    private $fsFactory;

    public function __construct(Staff $staff, Payrolls $payrolls, FileSystemFactory $fsFactory, $bus, $eventDispatcher)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->eventDispatcher = $eventDispatcher;
        $this->payrolls = $payrolls;
        $this->fsFactory = $fsFactory;
    }

    public function handle(Command $command)
    {
        $progress = new PayrollReporter(0, $this->staff->countAll());
        $this->prepareFiles($command->getPaths(), $command->getMonth());
        $this->eventDispatcher->dispatch(new PayrollDistributionStarted($progress));

        foreach ($this->staff as $employee) {
            $progress = $progress->advance();
            $this->bus->execute(new SendPayroll($employee, $command->getMonth(), $progress));
        }

        $this->eventDispatcher->dispatch(new AllPayrollsWereSent($progress, $command->getMonth()));
    }

    protected function prepareFiles($paths, $month)
    {
        foreach ($paths as $path) {
            $this->payrolls->loadArchive($month, $this->fsFactory->getZip(getcwd().'/var/inbox/'.$path));
        }
    }
}
