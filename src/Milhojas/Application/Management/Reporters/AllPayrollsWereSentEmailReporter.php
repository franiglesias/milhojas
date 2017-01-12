<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\Messaging\EventBus\Reporter\EmailReporter;
use Milhojas\Library\Messaging\EventBus\Event;

/**
* Creates an send an email report when all payrolls are sent
* 
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
