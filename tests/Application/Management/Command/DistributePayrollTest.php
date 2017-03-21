<?php

namespace Tests\Application\Management\Command;

// SUT

use Milhojas\Application\Management\Command\DistributePayroll;
use Milhojas\Application\Management\Command\DistributePayrollHandler;

// Domain concepts
use Milhojas\Application\Management\Command\SendPayroll;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\PayrollMonth;

// Repositories
use Milhojas\Infrastructure\Persistence\Management\YamlStaff;

// Fixtures and Doubles

use Milhojas\Messaging\EventBus\EventBus;
use Tests\Application\Utils\CommandScenario;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;
use Psr\Log\LoggerInterface;


/**
 * Description.
 */
class DistributePayrollTest extends CommandScenario
{
    private $mailer;
    private $staff;
    private $sender;

    public function setUp()
    {
        parent::setUp();
        $this->mailer = new MailerStub();
        $this->sender = 'sender@example.com';
        $this->root = (new NewPayrollFileSystem())->get();
        $this->staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
    }

    public function test_It_Handles_a_regular_distribution()
    {
        $now = new \DateTime();
        $dispatcher = $this->prophesize(EventBus::class);
        $command = new DistributePayroll(new PayrollMonth($now->format('m'), $now->format('Y')), array('test'));
        $handler = new DistributePayrollHandler($this->staff, $this->sender, $this->bus, $this->dispatcher);
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
