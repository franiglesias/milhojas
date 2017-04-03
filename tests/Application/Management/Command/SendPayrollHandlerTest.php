<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/3/17
 * Time: 12:23
 */

namespace Tests\Application\Management\Command;

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
use Milhojas\Infrastructure\Mail\MailerAttachment;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;
use Milhojas\Library\ValueObjects\Identity\Email;
use Milhojas\Library\ValueObjects\Identity\Person;
use Milhojas\Library\ValueObjects\Misc\Gender;
use Milhojas\Messaging\EventBus\EventBus;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;


class SendPayrollHandlerTest extends TestCase
{

    public function test_it_handles_command()
    {
        $handler = new SendPayrollHandler(
            $this->getPayrolls()->reveal(),
            'mail_template',
            'sender@example.com',
            $this->getMailer()->reveal(),
            $this->getDispatcher(PayrollEmailWasSent::class)->reveal()
        );
        $handler->handle($this->getCommand());
    }


    public function test_it_handles_mailer_exception()
    {
        $mailer = $this->getMailer();
        $mailer->send(Argument::type(MailMessage::class))->willThrow(\Swift_SwiftException::class);

        $handler = new SendPayrollHandler(
            $this->getPayrolls()->reveal(),
            'mail_template',
            'sender@example.com',
            $mailer->reveal(),
            $this->getDispatcher(PayrollEmailCouldNotBeSent::class)->reveal()
        );
        $handler->handle($this->getCommand());
    }


    public function test_it_handles_no_payroll_documents_found_for_employee()
    {
        $payrolls = $this->getPayrolls();
        $payrolls->getAttachments(Argument::type(Employee::class), Argument::type(PayrollMonth::class))->willThrow(
            EmployeeHasNoPayrollFiles::class
        )
        ;
        $mailer = $this->getMailer();
        $mailer->send(Argument::type(MailMessage::class))->shouldNotBeCalled();

        $handler = new SendPayrollHandler(
            $payrolls->reveal(),
            'mail_template',
            'sender@example.com',
            $mailer->reveal(),
            $this->getDispatcher(PayrollCouldNotBeFound::class)->reveal()
        );
        $handler->handle($this->getCommand());
    }

    /**
     * @return SendPayroll
     */
    protected function getCommand()
    {
        $employee = new Employee(
            new Email('employee@example.com'),
            new Person('Name', 'Last name', new Gender(Gender::MALE)),
            [123456]
        );
        $month = new PayrollMonth('03', '2017');
        $progress = new PayrollReporter(1, 10);
        $command = new SendPayroll($employee, $month, $progress);

        return $command;
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getDispatcher($event)
    {
        $dispatcher = $this->prophesize(EventBus::class);
        $dispatcher->dispatch(Argument::type($event))->shouldBeCalled();

        return $dispatcher;
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getPayrolls()
    {

        $payrolls = $this->prophesize(Payrolls::class);
        $attachment = $this->prophesize(MailerAttachment::class);
        $payrolls->getAttachments(Argument::type(Employee::class), Argument::type(PayrollMonth::class))->shouldBeCalled(
        )->willReturn([$attachment->reveal()])
        ;

        return $payrolls;
    }


    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getMailer()
    {
        $mailer = $this->prophesize(Mailer::class);
        $mailer->send(Argument::type(MailMessage::class))->shouldBeCalled();

        return $mailer;
    }


}
