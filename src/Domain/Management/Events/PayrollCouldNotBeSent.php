<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Payroll;
/**
* Description
*/
class PayrollCouldNotBeSent implements Event
{
	private $payroll;
	
	function __construct($payroll)
	{
		$this->payroll = $payroll;
	}
	
	public function getPayroll()
	{
		return $this->payroll;
	}
	
	public function getWorker()
	{
		return $this->payroll->getName();
	}
	
	public function getName()
	{
		return 'milhojas.management.payroll_could_not_be_sent';
	}
}

?>