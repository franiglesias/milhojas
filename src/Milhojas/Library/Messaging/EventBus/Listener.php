<?php

namespace Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\Event;

interface Listener {
	public function handle(Event $event);
}

?>
