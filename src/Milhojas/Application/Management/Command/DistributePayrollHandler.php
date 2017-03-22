<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\Payrolls;
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
    /**
     * @var Payrolls
     */
    private $payrolls;

    public function __construct(Staff $staff, Payrolls $payrolls, $sender, $bus, $eventDispatcher)
    {
        $this->bus = $bus;
        $this->staff = $staff;
        $this->sender = $sender;
        $this->eventDispatcher = $eventDispatcher;
        $this->payrolls = $payrolls;
    }

    public function handle(Command $command)
    {
        $progress = new PayrollReporter(0, $this->staff->countAll());
        $this->prepareFiles($command->getPaths(), $command->getMonth());
        $this->eventDispatcher->dispatch(new PayrollDistributionStarted($progress));

        foreach ($this->staff as $employee) {
            $progress = $progress->advance();
            $this->bus->execute(new SendPayroll($employee, $command->getMonth(), $command->getPaths(), $this->sender, $progress));
        }

        $this->eventDispatcher->dispatch(new AllPayrollsWereSent($progress, $command->getMonth()));
    }

    protected function prepareFiles($paths, $month)
    {
        foreach ($paths as $path) {
            $this->payrolls->loadArchive($month, new Filesystem(new ZipArchiveAdapter(getcwd().'/var/inbox/'.$path)));
        }
    }
}
