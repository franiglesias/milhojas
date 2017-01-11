<?php

namespace Milhojas\Application\Contents\Reporters;

use Milhojas\Library\Messaging\EventBus\Reporters\EmailReporter;
use Milhojas\Library\Messaging\EventBus\Event;
/**
* Responds to PostWasUpdated Event
* 
* Sends an e email message to notify that a post has been updated
*/
class PostWasUpdatedReporter extends EmailReporter
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
