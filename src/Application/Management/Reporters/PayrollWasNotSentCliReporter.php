<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\Reporters\CliReporter;
/**
* Handles PayrollWasSent and reports via cli
*/
class PayrollWasNotSentCliReporter extends CliReporter
{
	public function handle(Event $event)
	{
		$message = sprintf('%s. <options=bold>%s.</> <error>could not be sent</>. Error: %s', $event->getProgress(), $event->getEmployee(), $event->getError());
		$this->output->writeln($message);
	}
}
?>
