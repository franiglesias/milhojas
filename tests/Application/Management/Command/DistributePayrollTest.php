<?php

namespace Tests\Application\Management\Command;

// SUT

use Milhojas\Application\Management\Command\DistributePayroll;
use Milhojas\Application\Management\Command\DistributePayrollHandler;

// Domain concepts
use Milhojas\Domain\Management\PayrollMonth;

// Repositories
use Milhojas\Infrastructure\Persistence\Management\YamlStaff;

// Fixtures and Doubles

use Tests\Application\Utils\CommandScenario;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;

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
        $command = new DistributePayroll(new PayrollMonth($now->format('m'), $now->format('Y')), array('test'));
        $handler = new DistributePayrollHandler($this->staff, $this->sender, $this->bus);
        $this->sending($command)
            ->toHandler($handler)
            ->sendsCommand('Milhojas\Application\Management\Command\StartPayroll', 1)
            ->sendsCommand('Milhojas\Application\Management\Command\SendPayroll', 3)
            ->sendsCommand('Milhojas\Application\Management\Command\EndPayroll', 1)
            ->producesCommandHistory([
                'Milhojas\Application\Management\Command\StartPayroll',
                'Milhojas\Application\Management\Command\SendPayroll',
                'Milhojas\Application\Management\Command\SendPayroll',
                'Milhojas\Application\Management\Command\SendPayroll',
                'Milhojas\Application\Management\Command\EndPayroll',
            ])
        ;
    }
}
