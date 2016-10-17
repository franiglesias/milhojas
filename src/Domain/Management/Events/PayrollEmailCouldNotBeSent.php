<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* Describes the condition of a Payroll that could not be sent because there is no record for it in the email.dat database
*/
class PayrollEmailCouldNotBeSent implements Event
{
	private $employee;
	private $progress;
	
	public function __construct(Payroll $employee, Progress $progress)
	{
		$this->employee = $employee;
		$this->progress = $progress;
	}
	
	public function getPayroll()
	{
		return $this->employee;
	}
	
	public function getWorker()
	{
		return $this->employee->getName();
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
	
	
	public function getName()
	{
		return 'milhojas.management.employee_could_not_be_sent';
	}
	
	public function __toString()
	{
		return $this->getName();
	}
	
}

?>
