<?php


namespace Milhojas\Application\It\Reporters;

use Milhojas\Library\Messaging\EventBus\Reporter\EmailReporter;
use Milhojas\Library\Messaging\EventBus\Event;

/**
* Reports that a Device has some change
*/
class DeviceStatusEmailReporter extends EmailReporter
{
	
	protected function prepareTemplateParameters(Event $event)
	{
		return array(
			'device' => $event->getDevice(),
			'details' => $event->getDetails()
		);
	}
	
}
?>
