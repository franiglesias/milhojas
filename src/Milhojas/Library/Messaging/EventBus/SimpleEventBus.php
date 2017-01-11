<?php

namespace Milhojas\Library\Messaging\EventBus;

/**
 * It's a very simple Event Dispatcher.
 */
class SimpleEventBus implements EventBus
{
    private $handlers;
    private $logger;

    public function __construct($logger)
    {
        $this->handlers = array();
        $this->logger = $logger;
    }

    public function addListener($eventName, EventHandler $handler)
    {
        $this->handlers[$eventName][] = $handler;
    }

    public function subscribeListener(EventHandler $subscriber, array $events)
    {
        foreach ($events as $event) {
            $this->addListener($event, $subscriber);
        }
    }

    public function dispatch(Event $event)
    {
        if (!$this->canManageEvent($event)) {
            $this->logger->notice(sprintf('Event %s can not be handled', $event->getName()));

            return;
        }
        $this->logger->info($event);
        foreach ($this->handlers[$event->getName()] as $handler) {
            $handler->handle($event);
        }
    }

    private function canManageEvent($event)
    {
        return isset($this->handlers[$event->getName()]);
    }
}
