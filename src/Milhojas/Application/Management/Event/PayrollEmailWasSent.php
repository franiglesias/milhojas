<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Messaging\EventBus\Event;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
 * Describes a Payroll that was sent by the system.
 *
 * Delivery could fail if email doesn't exists
 */
class PayrollEmailWasSent implements Event
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
     * @var PayrollMonth
     */
    private $month;
    /**
     * @var array
     */
    private $repositories;

    public function __construct(Employee $employee, PayrollMonth $month, $repositories, Progress $progress)
    {
        $this->employee = $employee;
        $this->progress = $progress;
        $this->month = $month;
        $this->repositories = $repositories;
    }

    /**
     * @return PayrollMonth
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return array
     */
    public function getRepositories()
    {
        return $this->repositories;
    }

    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @return Progress
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @return
     */
    public function getProgressDataAsJson()
    {
        return $this->progress->asJson();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'management.payroll_email_was_sent.event';
    }

    public function __toString()
    {
        return sprintf('Se ha enviado la nómina a %s (%s). Progreso: %s', $this->employee->getFullName(), $this->employee->getEmail(), $this->progress);
    }
}
