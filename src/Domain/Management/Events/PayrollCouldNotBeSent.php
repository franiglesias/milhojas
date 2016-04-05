<?php

namespace Milhojas\Domain\Management\Events;

use Milhojas\Library\EventBus\Event;
use Milhojas\Domain\Management\Payroll;
/**
* Description
*/
class PayrollCouldNotBeSent implements Event
{
	private $id;
	
	function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return 'milhojas.management.payroll_could_not_be_sent';
	}
}

?>