<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;

/**
* Sends a unique payroll file from a sender for a month
*/
class EmailPayroll implements Command
{
	private $payroll;
	private $month;
	private $sender;
	private $progress;
	
	function __construct($payroll, $sender, $month, $progress)
	{
		$this->payroll = $payroll;
		$this->month = $month;
		$this->sender = $sender;
		$this->progress = $progress;
	}
	
	public function getPayroll()
	{
		return $this->payroll;
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