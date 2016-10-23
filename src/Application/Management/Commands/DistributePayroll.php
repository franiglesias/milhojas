<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Library\CommandBus\Command;

/**
* Performs Payroll distribution for a month
*/
class DistributePayroll implements Command
{
	private $month;
	private $paths;
	
	public function __construct($month, $paths)
	{
		$this->month = $month;
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
