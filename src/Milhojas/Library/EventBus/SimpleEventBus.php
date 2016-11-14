<?php

namespace Milhojas\Library\EventBus;


use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\EventBus\Event;
/**
* It's a very simple Event Dispatcher
*/
class SimpleEventBus implements EventBus
{
	private $handlers;
	private $logger;
	
	public function __construct($logger)
	{
		$this->handlers = array();
		$this->logger = $logger;
	}
	
	public function addHandler($eventName, EventHandler $handler)
	{
		$this->handlers[$eventName][] = $handler;
	}
	
	public function subscribeHandler(EventHandler $subscriber, array $events)
	{
		foreach ($events as $event) {
			$this->addHandler($event, $subscriber);
		}
	}
	
	public function handle(Event $event)
	{
		if (! $this->canManageEvent($event)) {
			$this->logger->notice(sprintf('Event %s can not be handled', $event->getName() ));
			return;
		}
		$this->logger->info($event);
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
