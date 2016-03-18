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
		$this->handlers = array();
	}
	
	public function addHandler($eventName, EventHandler $handler)
	{
		$this->handlers[$eventName][] = $handler;
	}
	
	public function handle(Event $event)
	{
		if (! $this->canManageEvent($event)) {
			return;
		}
		foreach ($this->handlers[$event->getName()] as $handler) {
			$handler->handle($event);
		}
	}
	
	private function canManageEvent($event)
	{
		return isset($this->handlers[$event->getName()]);
	}
}

?>