<?php

namespace Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\Event;

interface EventHandler {
	public function handle(Event $event);
}

?>
