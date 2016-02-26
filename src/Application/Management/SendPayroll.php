<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;

/**
* Description
*/
class SendPayroll implements Command
{
	private $month;
	private $sender;
	
	function __construct($sender, $month)
	{
		$this->month = $month;
		$this->sender = $sender;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
	
	public function getSender()
	{
		return $this->sender;
	}
}


?>