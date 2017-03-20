<?php

namespace Milhojas\Application\Management\Event;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* Describes a Payroll that was sent by the system
* 
* Delivery could fail if email doesn't exists
*/
class PayrollDistributionStarted implements Event
{
	private $progress;
	
	public function __construct(Progress $progress)
	{
		$this->progress = $progress;
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
	
	public function getName()
	{
		return 'management.payroll_distribution_started.event';
	}
	
	public function __toString()
	{
		return $this->getName().' '.$this->progress;
	}
}

?>
