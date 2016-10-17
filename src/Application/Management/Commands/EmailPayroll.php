<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Library\CommandBus\Command;

/**
* It send a employeee its payrolls for a month
*/
class EmailPayroll implements Command
{
	private $employee;
	private $month;
	private $sender;
	private $progress;
	
	public function __construct($employee, $sender, $month, $progress)
	{
		$this->employee = $employee;
		$this->month = $month;
		$this->sender = $sender;
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
	
	public function getSender()
	{
		return $this->sender;
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
}


?>
