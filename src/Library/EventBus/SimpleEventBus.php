<?php

namespace Milhojas\Library\EventBus;


use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\EventBus\Event;
/**
* Description
*/
class SimpleEventBus implements EventBus
{
	private $handlers;
	
	public function __construct()
	{
		
	}
	
	public function addHandler($eventName, EventHandler $handler)
	{
		$this->handlers[$eventName][] = $handler;
	}
	
	public function handle(Event $event)
	{
		$name = $event->getName();
		foreach ($this->handlers[$name] as $handler) {
			$handler->handle($event);
		}

	}
}

?>