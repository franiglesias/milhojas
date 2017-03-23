<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Event\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;
use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventBus;


// Events

// Application Messaging infrastructure

// Mailer

// Exceptions

/**
 * Manages SendPayroll command.
 */
class SendPayrollHandler implements CommandHandler
{
    private $payrolls;
    private $template;
    private $mailer;
    private $dispatcher;
    /**
     * @var
     */
    private $sender;

    public function __construct(Payrolls $payrolls, $template, $sender, Mailer $mailer, EventBus $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
        $this->payrolls = $payrolls;
        $this->template = $template;
        $this->sender = $sender;
    }

    /**
     * Gets the employee, prepares and sends an email message with the payrolls attached.
     *
     * @param Command $command
     *
     * @author Fran Iglesias
     */
    public function handle(Command $command)
    {
        $employee = $command->getEmployee();
        try {
            $this->sendEmail($employee, $this->sender, $command->getMonth());
            $this->dispatcher->dispatch(
                new PayrollEmailWasSent($employee, $command->getMonth(), $command->getProgress()->addSent())
            );
        } catch (EmployeeHasNoPayrollFiles $e) {
            $this->dispatcher->dispatch(new PayrollCouldNotBeFound($employee, $command->getProgress()->addNotFound()));
        } catch (\Swift_SwiftException $e) {
            $this->dispatcher->dispatch(new PayrollEmailCouldNotBeSent($employee, $e->getMessage(), $command->getProgress()->addFailed()));
        }
    }

    /**
     * Builds and send the email message to the employee.
     *
     * @param Employee     $employee
     * @param string       $sender
     * @param PayrollMonth $month
     *
     * @return bool true on success
     *
     * @throws \Swift_SwiftException if failed to send the message
     *
     * @author Fran Iglesias
     */
    private function sendEmail(Employee $employee, $sender, PayrollMonth $month)
    {
        $message = new MailMessage();
        $message
            ->setTo($employee->getEmail())
            ->setSender($sender)
            ->setTemplate($this->template, array('employee' => $employee, 'month' => $month));
        $attachments = $this->payrolls->getAttachments($employee, $month);
        foreach ($attachments as $attachment) {
            $message->attach($attachment);
        }
        return $this->mailer->send($message);
    }
}
