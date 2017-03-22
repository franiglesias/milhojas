<?php

namespace Milhojas\Application\Management\Command;

// Domain concepts

use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Employee;
// Events

use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Application\Management\Event\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;

// Application Messaging infrastructure

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;
use Milhojas\Messaging\EventBus\EventBus;

// Mailer

use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

// Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;

/**
 * Manages SendPayroll command.
 */
class SendPayrollHandler implements CommandHandler
{
    private $payrolls;
    private $template;
    private $mailer;
    private $dispatcher;

    public function __construct(Payrolls $payrolls, $template, Mailer $mailer, EventBus $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
        $this->payrolls = $payrolls;
        $this->template = $template;
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
            $this->sendEmail($employee, $command->getSender(), $command->getPaths(), $command->getMonth());
            $this->dispatcher->dispatch(new PayrollEmailWasSent($employee, $command->getMonth(), $command->getPaths(), $command->getProgress()->addSent()));
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
     * @param array        $paths    the files to send
     * @param PayrollMonth $month
     *
     * @return bool true on success
     *
     * @author Fran Iglesias
     */
    private function sendEmail(Employee $employee, $sender, $paths, PayrollMonth $month)
    {
        $message = new MailMessage();
        $message
            ->setTo($employee->getEmail())
            ->setSender($sender)
            ->setTemplate($this->template, array('employee' => $employee, 'month' => $month));
        $attachments = $this->getPayrollDocuments($employee, $paths, $month);
        foreach ($attachments as $attachment) {
            // TODO: mailer needs a method to attach data
            $message->attach(\Swift_Attachment::newInstance($attachment['data'], $attachment['filename'], $attachment['type']));
        }
        return $this->mailer->send($message);
    }

    /**
     * Gets an array of paths to the payroll documents associated to employee.
     *
     * @param Employee     $employee
     * @param array        $paths
     * @param PayrollMonth $month
     *
     * @return array
     *
     * @author Fran Iglesias
     */
    private function getPayrollDocuments(Employee $employee, $paths, PayrollMonth $month)
    {

        return $this->payrolls->getAttachments($employee, $month);

    }
}
