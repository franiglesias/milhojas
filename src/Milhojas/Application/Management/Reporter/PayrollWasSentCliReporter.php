<?php

namespace Milhojas\Application\Management\Reporter;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Reporter\CliReporter;
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
