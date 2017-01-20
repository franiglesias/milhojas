<?php

namespace Milhojas\Application\Management\Command;

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Domain\Management\PayrollMonth;

/**
* Performs Payroll distribution for a month
*/
class DistributePayroll implements Command
{
	private $month;
	private $paths;
	
	public function __construct(PayrollMonth $month, $paths)
	{
		$this->month = $month;
		$this->paths = $paths;
	}
	
	public function getPaths ()
	{
		return $this->paths;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
} 

?>
