<?php

namespace Milhojas\Library\Messaging\EventBus;

interface Listener
{
    public function handle(Event $event);
}
