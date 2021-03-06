<?php

namespace Milhojas\Application\Management\Reporter;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Reporter\CliReporter;
/**
* Handles the event that payroll could not be sent and reports via CLI
*/
class PayrollCouldNotBeSentCliReporter extends CliReporter
{	
	public function handle(Event $event)
	{
		$message = sprintf('%s. <options=bold>%s.</> No payroll document found for this employee.', $event->getProgress(), $event->getEmployee());
		$this->output->writeln($message);
	}
}
?>
