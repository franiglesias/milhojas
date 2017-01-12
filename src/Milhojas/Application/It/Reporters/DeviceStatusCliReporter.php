<?php

namespace Milhojas\Application\It\Reporters;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Reporter\CliReporter;
/**
* Handles events related to Device Status
*/
class DeviceStatusCliReporter extends CliReporter
{
	public function handle(Event $event)
	{
		$this->output->writeln('<options=bold>'.$event->getDevice().'</> reports the following:');
		$this->output->writeln('<error>');
		$this->output->writeln( explode(chr(10), $event->getDetails() ) );
		$this->output->writeln('</>');
	}
}
?>
