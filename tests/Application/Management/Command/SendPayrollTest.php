<?php

namespace Tests\Application\Management\Command;

// SUT
use Milhojas\Application\Management\Command\SendPayroll;
use Milhojas\Application\Management\Command\SendPayrollHandler;
use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Event\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;
use Prophecy\Argument;
use Tests\Application\Utils\CommandScenario;


// Domain concepts

// Repositories


// Components

// Fixtures and Doubles


class SendPayrollTest extends CommandScenario
{
    private $mailer;
    private $payrolls;

    protected $command;

    protected $employee;

    public function setUp()
    {
        parent::setUp();
        $this->mailer = $this->prophesize(Mailer::class);
        $this->payrolls = $this->prophesize(Payrolls::class);
        $this->employee = $this->prophesize(Employee::class);

        $this->command = new SendPayroll(
            $this->employee->reveal(), new PayrollMonth('01', '2017'), new PayrollReporter(1, 2)
        );

    }

    public function test_command_transports_needed_data()
    {

        $this->assertEquals($this->employee->reveal(), $this->command->getEmployee());
        $this->assertEquals('2017/01', $this->command->getMonth()->getFolderName());
        $this->assertEquals(new PayrollReporter(1, 2), $this->command->getProgress());

    }

    public function test_it_handles_sending_payroll_documents_to_employee()
    {
        $this->payrolls->getAttachments($this->employee->reveal(), Argument::type(PayrollMonth::class))->willReturn(
            ['attachment']
        )
        ;

        $handler = new SendPayrollHandler(
            $this->payrolls->reveal(), 'template', 'email@example.com', $this->mailer->reveal(), $this->dispatcher
        );
        $this->sending($this->command)
            ->toHandler($handler)
            ->raisesEvent(PayrollEmailWasSent::class)
            ->produces(
                $this->mailer->send(Argument::type(MailMessage::class))->shouldHaveBeenCalled()
            )
        ;
    }


    public function test_it_handles_employee_with_no_attachments()
    {
        $this->payrolls->getAttachments($this->employee->reveal(), Argument::type(PayrollMonth::class))->willThrow(
            EmployeeHasNoPayrollFiles::class
        )
        ;

        $handler = new SendPayrollHandler(
            $this->payrolls->reveal(), 'template', 'email@example.com', $this->mailer->reveal(), $this->dispatcher
        );
        $this->sending($this->command)
            ->toHandler($handler)
            ->raisesEvent(PayrollCouldNotBeFound::class)
            ->produces(
                $this->mailer->send(Argument::type(MailMessage::class))->shouldNotHaveBeenCalled()
            )
        ;
    }

    public function test_it_handles_problems_with_mailer()
    {
        $this->payrolls->getAttachments($this->employee->reveal(), Argument::type(PayrollMonth::class))->willReturn(
            ['attachment']
        )
        ;
        $this->mailer->send(Argument::type(MailMessage::class))->willThrow(\Swift_SwiftException::class);
        $handler = new SendPayrollHandler(
            $this->payrolls->reveal(), 'template', 'email@example.com', $this->mailer->reveal(), $this->dispatcher
        );
        $this->sending($this->command)
            ->toHandler($handler)
            ->raisesEvent(PayrollEmailCouldNotBeSent::class)
        ;
    }
}
