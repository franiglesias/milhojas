<?php

namespace Milhojas\Application\Management\Reporter;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Reporter\CliReporter;
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