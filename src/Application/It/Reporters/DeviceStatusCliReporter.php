<?php

namespace Milhojas\Application\It\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\Reporters\CliReporter;
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