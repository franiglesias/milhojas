<?php

namespace Milhojas\Library\Messaging\EventBus\Worker;

use Milhojas\Library\Messaging\EventBus\Loader\ListenerLoader;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use Milhojas\Library\Messaging\Shared\Message;
use Milhojas\Library\Messaging\EventBus\Event;

class DispatcherWorker extends MessageWorker
{
    private $loader;

    public function __construct(ListenerLoader $loader)
    {
        $this->loader = $loader;
    }

    public function execute(Message $event)
    {
        $listeners = $this->getListeners($event);
        foreach ($listeners as $listener) {
            $listener->handle($event);
        }
    }

    public function getListeners(Event $event)
    {
        return $this->loader->get($event->getName());
    }
}
