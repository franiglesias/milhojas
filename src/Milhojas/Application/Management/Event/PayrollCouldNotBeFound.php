<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
 * Describes the condition of an Employee that had no payroll documents for a month.
 */
class PayrollCouldNotBeFound implements Event
{
    private $employee;
    private $progress;

    public function __construct(Employee $employee, Progress $progress)
    {
        $this->employee = $employee;
        $this->progress = $progress;
    }

    public function getEmployee()
    {
        return $this->employee;
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
        return 'management.payroll_could_not_be_found.event';
    }

    public function __toString()
    {
        return sprintf('No se han encontrado nóminas para %s (%s). Progreso: %s.', $this->employee->getFullName(), $this->employee->getEmail(), $this->progress);
    }
}
