<?php

namespace Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;

class EventBus
{
    private $pipeline;

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    public function dispatch(Event $event)
    {
        $this->pipeline->work($event);
    }
}
