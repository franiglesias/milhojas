<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;

interface EventBus {
	public function handle(Event $event);
	public function addHandler($eventName, EventHandler $listener);
}

?>