<?php

namespace Tests\Application\Management\Command;

// SUT

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Command\DistributePayroll;
use Milhojas\Application\Management\Command\DistributePayrollHandler;
use Milhojas\Application\Management\Command\SendPayroll;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\Staff;
use Milhojas\Infrastructure\FileSystem\FileSystemFactory;
use Milhojas\Infrastructure\Mail\Mailer;
use Prophecy\Argument;
use Tests\Application\Utils\CommandScenario;


// Domain concepts

// Repositories


// Fixtures and Doubles


/**
 * Description.
 */
class DistributePayrollTest extends CommandScenario
{
    private $mailer;
    private $staff;

    protected $fsFactory;

    public function setUp()
    {
        parent::setUp();
        $this->mailer = $this->prophesize(Mailer::class);

        $this->prepareStaff();
        $this->prepareFileSystemFactory();

    }

    public function test_It_Handles_a_regular_distribution()
    {
        $payrolls = $this->prophesize(Payrolls::class);

        $command = new DistributePayroll(PayrollMonth::current(), ['archive.zip']);
        $handler = new DistributePayrollHandler(
            $this->staff->reveal(),
            $payrolls->reveal(),
            $this->fsFactory->reveal(),
            $this->bus,
            $this->dispatcher
        );
        $this->sending($command)
            ->toHandler($handler)
            ->sendsCommand(SendPayroll::class, 3)
            ->producesCommandHistory(
                [
                    SendPayroll::class,
                    SendPayroll::class,
                    SendPayroll::class,
                ]
            )
            ->producesEventHistory(
                [
                    PayrollDistributionStarted::class,
                    AllPayrollsWereSent::class
                ]

            )
        ;
    }

    protected function prepareStaff()
    {
        $employees = array_fill(0, 3, $this->prophesize(Employee::class)->reveal());
        $this->staff = $this->prophesize(Staff::class);
        $this->staff->countAll()->willReturn(3);
        $this->staff->getIterator()->willReturn(new \ArrayIterator($employees));
    }

    protected function prepareFileSystemFactory()
    {
        $zip = $this->prophesize(FilesystemInterface::class);
        $this->fsFactory = $this->prophesize(FileSystemFactory::class);

        $this->fsFactory->getZip(Argument::type('string'))->willReturn($zip->reveal());
    }
}
