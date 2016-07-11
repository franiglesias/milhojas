<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\Reporters\CliReporter;
/**
* Handles the event that payroll could not be sent and reports via CLI
*/
class PayrollCouldNotBeSentCliReporter extends CliReporter
{	
	public function handle(Event $event)
	{
		$message = sprintf('%s. <error><options=bold>%s.</> could not be sent</>', $event->getProgress(), $event->getPayroll());
		$this->output->writeln($message);
	}
}
?>