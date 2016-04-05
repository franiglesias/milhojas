<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Payroll;
/**
* Describes a Payroll that was sent by the system
* 
* Delivery could fail if email doesn't exists
*/
class PayrollWasSent implements Event
{
	private $payroll;
	
	function __construct(Payroll $payroll)
	{
		$this->payroll = $payroll;
	}
	
	public function getPayroll()
	{
		return $this->payroll;
	}
	
	public function getName()
	{
		return 'milhojas.management.payroll_was_sent';
	}
}

?>