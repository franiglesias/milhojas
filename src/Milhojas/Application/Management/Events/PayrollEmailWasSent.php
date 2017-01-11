<?php

namespace Milhojas\Application\Management\Events;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* Describes a Payroll that was sent by the system
* 
* Delivery could fail if email doesn't exists
*/
class PayrollEmailWasSent implements Event
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
	
	public function getName()
	{
		return 'milhojas.management.payroll_email_was_sent';
	}
	
	public function __toString()
	{
		return $this->getName();
	}
}

?>
