<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Event;

interface EventHandler {
	public function handle(Event $event);
}

?>