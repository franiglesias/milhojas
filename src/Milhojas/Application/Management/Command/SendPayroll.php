<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\CommandBus\Command;


/**
* It sends employee's payroll for a month
*/
class SendPayroll implements Command
{
	private $employee;
	private $month;
	private $progress;

    public function __construct(Employee $employee, PayrollMonth $month, PayrollReporter $progress)
	{
		$this->employee = $employee;
		$this->month = $month;
		$this->progress = $progress;
	}
	
	public function getEmployee()
	{
		return $this->employee;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
}


?>
