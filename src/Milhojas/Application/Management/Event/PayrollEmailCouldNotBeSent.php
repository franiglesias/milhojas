<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
 * Describes the condition of a Payroll that could not be sent because there is no record for it in the database.
 */
class PayrollEmailCouldNotBeSent implements Event
{
    /**
     * @var Employee
     */
    private $employee;
    /**
     * @var Progress
     */
    private $progress;
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(Employee $employee, $error_message, Progress $progress)
    {
        $this->employee = $employee;
        $this->progress = $progress;
        $this->errorMessage = $error_message;
    }

    public function getEmployee()
    {
        return $this->employee;
    }

    public function getError()
    {
        return $this->errorMessage;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function getProgressDataAsJson()
    {
        return $this->progress->asJson();
    }

    public function getName()
    {
        return 'management.payroll_email_could_not_be_sent.event';
    }

    public function __toString()
    {
        return sprintf('Email not sent to %s (%s). Reason: %s. Progress: %s',
                       $this->employee->getFullName(),
                       $this->errorMessage,
                       $this->progress);
    }
}
