<?php

namespace Tests\Library\EventBus\Fixtures;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;

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
