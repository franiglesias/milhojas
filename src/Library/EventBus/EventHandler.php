<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventSourcing\Domain\Event;

interface EventHandler {
	public function handle(Event $event);
}

?>