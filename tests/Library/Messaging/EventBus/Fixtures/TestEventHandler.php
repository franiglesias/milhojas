<?php

namespace Tests\Library\Messaging\EventBus\Fixtures;

use Milhojas\Library\Messaging\EventBus\Listener;
use Milhojas\Library\Messaging\EventBus\Event;

/**
* A test event handler
*/
class TestListener implements Listener
{
	private $bus;
public function __construct($bus)
	{
		$this->bus = $bus;
	}
	
	public function handle(Event $event)
	{
		$this->bus->recordHandler($event, 'TestListener');
	}
}


?>
