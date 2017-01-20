<?php

namespace Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\Shared\Worker\Worker;

class EventBus
{
    private $pipeline;

    public function __construct(Worker $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    public function dispatch(Event $event)
    {
        $this->pipeline->work($event);
    }
}
