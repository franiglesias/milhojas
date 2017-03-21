<?php

namespace Tests\Application\Management\Command;

// SUT
use Milhojas\Application\Management\Command\SendPayroll;
use Milhojas\Application\Management\Command\SendPayrollHandler;

// Domain concepts
use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Event\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\PayrollMonth;

// Repositories
use Milhojas\Infrastructure\Persistence\Management\FileSystemPayrolls;

// Components

// Fixtures and Doubles

use Tests\Application\Utils\CommandScenario;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;

class SendPayrollTest extends CommandScenario
{
    private $mailer;
    private $root;
    private $payrolls;

    public function setUp()
    {
        parent::setUp();
        $this->mailer = new MailerStub();
        $this->root = (new NewPayrollFileSystem())->get();
        $this->payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
    }

    public function testItHandlesEmployeeWithOnePayrollDocument()
    {
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $command = new SendPayroll($employee, new PayrollMonth('01', '2017'), 'test', 'email@example.com', new PayrollReporter(1, 2));
        $handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->dispatcher);
        $this->sending($command)
            ->toHandler($handler)
            ->raisesEvent(PayrollEmailWasSent::class)
            ->produces($this->mailer->wasCalled())
            ->produces($this->mailer->aMessageWasSentTo('user@example.com'))
            ->produces($this->mailer->attachmentsInMessage() === 1)
        ;
    }

    public function testItHandlesEmployeeWithNoDocuments()
    {
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(55555));
        $command = new SendPayroll($employee, new PayrollMonth('01', '2017'), 'test', 'email@example.com', new PayrollReporter(1, 2));
        $handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->dispatcher);
        $this->sending($command)
            ->toHandler($handler)
            ->raisesEvent(PayrollCouldNotBeFound::class);
    }

    public function testItHandlesMessageCouldNotBeSent()
    {
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $command = new SendPayroll($employee, new PayrollMonth('01', '2017'), 'test', 'email@example.com', new PayrollReporter(1, 2));
        $handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->dispatcher);
        $this->mailer->makeFail();
        $this->sending($command)
            ->toHandler($handler)
            ->raisesEvent(PayrollEmailCouldNotBeSent::class);
    }

    public function testItHandlesEmployeeWithSeveralFiles()
    {
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
        $command = new SendPayroll($employee, new PayrollMonth('01', '2017'), 'test', 'email@example.com', new PayrollReporter(1, 2));
        $handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->dispatcher);
        $this->sending($command)
            ->toHandler($handler)
            ->raisesEvent(PayrollEmailWasSent::class)
            ->produces($this->mailer->wasCalled())
            ->produces($this->mailer->aMessageWasSentTo('user@example.com'))
            ->produces($this->mailer->attachmentsInMessage() === 2);
    }
}
