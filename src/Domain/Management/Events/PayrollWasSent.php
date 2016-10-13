<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Payroll;

use Milhojas\Library\ValueObjects\Misc\Progress;
/**
* Describes a Payroll that was sent by the system
* 
* Delivery could fail if email doesn't exists
*/
class PayrollWasSent implements Event
{
	private $payroll;
	private $progress;
	
	function __construct(Payroll $payroll, Progress $progress)
	{
		$this->payroll = $payroll;
		$this->progress = $progress;
	}
	
	public function getPayroll()
	{
		return $this->payroll;
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
	
	public function getName()
	{
		return 'milhojas.management.payroll_was_sent';
	}
	
	public function __toString()
	{
		return $this->getName();
	}
}

?>
