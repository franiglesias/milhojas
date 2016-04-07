<?php

namespace Tests\Library\EventBus\Fixtures;

use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Library\EventSourcing\Domain\Event;

/**
* A test event handler
*/
class TestEventHandler implements EventHandler
{
	private $bus;
	function __construct($bus)
	{
		$this->bus = $bus;
	}
	
	public function handle(Event $event)
	{
		$this->bus->recordHandler($event, 'TestEventHandler');
	}
}


?>