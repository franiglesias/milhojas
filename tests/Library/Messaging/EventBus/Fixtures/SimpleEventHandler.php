<?php

namespace Tests\Library\Messaging\EventBus\Fixtures;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\EventHandler;

/**
* A test event handler
*/
class SimpleEventHandler implements EventHandler
{
	private $bus;
public function __construct($bus)
	{
		$this->bus = $bus;
	}
	
	public function handle(Event $event)
	{
		$this->bus->recordHandler($event, 'SimpleEventHandler');
	}
}


?>
