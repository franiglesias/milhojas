<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;

interface EventBus {
	public function handle(Event $event);
	public function addHandler($eventName, EventHandler $listener);
	public function subscribeHandler(EventHandler $subscriber, array $events);
}

?>