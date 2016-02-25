<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;

/**
* Description
*/
class SendPayroll implements Command
{
	private $month;
	
	function __construct($month)
	{
		$this->month = $month;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
}


?>