<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Library\CommandBus\Command;

/**
* It sends employee's payroll for a month
*/
class SendPayroll implements Command
{
	private $employee;
	private $month;
	private $sender;
	private $progress;
	private $paths;
	
	public function __construct($employee, $paths, $sender, $month, $progress)
	{
		$this->employee = $employee;
		$this->month = $month;
		$this->sender = $sender;
		$this->progress = $progress;
		$this->paths = $paths;
	}
	
	public function getPaths ()
	{
		return $this->paths;
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
