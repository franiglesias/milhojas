<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\EventBus\Event;

/**
* Broadcasts an arbitrary event
* 
* Useful when you need to raise an Event without an EventRecorder
*/

class BroadcastEvent implements Command
{
	private $event;
	
	public function __construct(Event $event)
	{
		$this->event = $event;
	}
	
	public function getEvent()
	{
		return $this->event;
	}
}

?>