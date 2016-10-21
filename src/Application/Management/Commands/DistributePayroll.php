<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Library\CommandBus\Command;

/**
* Performs Payroll distribution for a month
*/
class DistributePayroll implements Command
{
	private $month;
	
	public function __construct($month)
	{
		$this->month = $month;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
} 

?>
