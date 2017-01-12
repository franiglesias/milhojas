<?php

namespace Milhojas\Application\Contents\Reporter;

use Milhojas\Library\Messaging\EventBus\Reporter\EmailReporter;
use Milhojas\Library\Messaging\EventBus\Event;

/**
* Responds to NewPostWasWritten Event
* 
* Sends an email message to notify that a new post was written
*/
class NewPostWasWrittenReporter extends EmailReporter
{
	
	protected function prepareTemplateParameters(Event $event)
	{
		return array(
			'id' => $event->getId(),
			'title' => $event->getTitle(),
			'author' => $event->getAuthor()
		);
	}
}
?>
