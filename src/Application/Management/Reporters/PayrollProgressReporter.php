<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Library\EventBus\Event;
/**
* Writes Payroll Distribution Progress to the json file specified in the constructor
*/
class PayrollProgressReporter implements EventHandler
{
	private $file;
	
	public function __construct($file)
	{
		$this->file = $file;
	}
	
	public function handle(Event $event)
	{
		file_put_contents($this->file, $event->getProgress()->asJson());
	}
}

?>
