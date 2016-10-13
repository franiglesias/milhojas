<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\Reporters\CliReporter;
/**
* Handles PayrollWasSent and reports via cli
*/
class PayrollWasSentCliReporter extends CliReporter
{
	
	public function handle(Event $event)
	{
		$message = sprintf('%s. <options=bold>%s.</> was sent', $event->getProgress(), $event->getPayroll());
		$this->output->writeln($message);
	}
	
	
}
?>
