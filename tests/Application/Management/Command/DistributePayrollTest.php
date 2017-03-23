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

    public function setUp()
    {
        parent::setUp();
        $this->mailer = $this->prophesize(Mailer::class);
        $this->staff = $this->prophesize(Staff::class);
    }

    public function test_It_Handles_a_regular_distribution()
    {
        $fsFactory = $this->prophesize(FileSystemFactory::class);
        $zip = $this->prophesize(FilesystemInterface::class);
        $fsFactory->getZip(Argument::type('string'))->willReturn($zip->reveal());
        $now = new \DateTime();
        $payrolls = $this->prophesize(Payrolls::class);
        $employees = array_fill(0, 3, $this->prophesize(Employee::class)->reveal());
        $this->staff->countAll()->willReturn(3);
        $this->staff->getIterator()->willReturn(new \ArrayIterator($employees));
        $command = new DistributePayroll(new PayrollMonth($now->format('m'), $now->format('Y')), array('test'));
        $handler = new DistributePayrollHandler(
            $this->staff->reveal(),
            $payrolls->reveal(),
            $fsFactory->reveal(),
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
}
