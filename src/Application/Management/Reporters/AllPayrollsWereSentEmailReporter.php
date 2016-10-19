<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Reporters\EmailReporter;
use Milhojas\Library\EventBus\Event;
/**
* Responds to PostWasUpdated Event
* 
* Sends an e email message to notify that a post has been updated
*/
class AllPayrollsWereSentEmailReporter extends EmailReporter
{	
	protected function prepareTemplateParameters(Event $event)
	{
		return array(
				'month' => $event->getMonth(), 
				'sent'  => $event->getProgress()->getCurrent(), 
				'total' => $event->getProgress()->getTotal(),
				'employees' => $event->getProgress()->getTotal(),
				'ok' => $event->getProgress()->getSent(),
				'not_found' => $event->getProgress()->getNotFound(),
				'failed' => $event->getProgress()->getFailed()
			);
	}
 }
?>
