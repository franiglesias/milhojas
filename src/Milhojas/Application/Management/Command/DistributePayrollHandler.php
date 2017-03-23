<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\Staff;
use Milhojas\Infrastructure\FileSystem\FileSystemFactory;
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
     * Need this to access zip archives
     * @var FileSystemFactory
     */
    private $fsFactory;

    /**
     * DistributePayrollHandler constructor.
     *
     * @param Staff             $staff
     * @param Payrolls          $payrolls
     * @param FileSystemFactory $fsFactory
     * @param                   $bus
     * @param                   $eventDispatcher
     */
    public function __construct(Staff $staff, Payrolls $payrolls, FileSystemFactory $fsFactory, $bus, $eventDispatcher)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->eventDispatcher = $eventDispatcher;
        $this->payrolls = $payrolls;
        $this->fsFactory = $fsFactory;
    }

    /**
     * @param Command $command
     */
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

    /**
     * @param $paths
     * @param $month
     */
    protected function prepareFiles($paths, $month)
    {
        foreach ($paths as $path) {
            $this->payrolls->loadArchive($month, $this->fsFactory->getZip(getcwd().'/var/inbox/'.$path));
        }
    }
}
