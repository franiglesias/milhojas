<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* All payrolls were sent
* 
*/
class AllPayrollsWereSent implements Event
{
	private $month;
	private $progress;
	
	public function __construct(Progress $progress, $month)
	{
		$this->month = $month;
		$this->progress = $progress;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
	
	public function getName()
	{
		return 'management.all_payrolls_were_sent.event';
	}
	
	public function __toString()
	{
		return $this->getName();
	}
}

?>
