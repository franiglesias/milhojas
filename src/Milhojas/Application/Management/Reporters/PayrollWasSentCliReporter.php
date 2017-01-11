<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Reporters\CliReporter;
/**
* Handles PayrollWasSent and reports via cli
*/
class PayrollWasSentCliReporter extends CliReporter
{
	public function handle(Event $event)
	{
		$message = sprintf('%s. <options=bold>%s.</> was sent', $event->getProgress(), $event->getEmployee());
		$this->output->writeln($message);
	}
}
?>
