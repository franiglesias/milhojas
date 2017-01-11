<?php

namespace Tests\Library\Messaging\EventBus\Fixtures;

use Milhojas\Library\Messaging\EventBus\EventHandler;
use Milhojas\Library\Messaging\EventBus\Event;

/**
* A test event handler
*/
class TestEventHandler implements EventHandler
{
	private $bus;
public function __construct($bus)
	{
		$this->bus = $bus;
	}
	
	public function handle(Event $event)
	{
		$this->bus->recordHandler($event, 'TestEventHandler');
	}
}


?>
