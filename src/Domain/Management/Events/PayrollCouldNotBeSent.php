<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Payroll;
use Milhojas\Library\ValueObjects\Misc\Progress;
/**
* Describes the conditions of a Payroll that could not be sent because there is no record for it in the email.dat database
*/
class PayrollCouldNotBeSent implements Event
{
	private $payroll;
	private $progress;
public function __construct(Payroll $payroll, Progress $progress)
	{
		$this->payroll = $payroll;
		$this->progress = $progress;
	}
	
	public function getPayroll()
	{
		return $this->payroll;
	}
	
	public function getWorker()
	{
		return $this->payroll->getName();
	}
	
	public function getProgress()
	{
		return $this->progress;
	}
	
	
	public function getName()
	{
		return 'milhojas.management.payroll_could_not_be_sent';
	}
	
	public function __toString()
	{
		return $this->getName();
	}
	
}

?>
