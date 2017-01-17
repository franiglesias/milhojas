<?php

namespace Milhojas\Library\Messaging\EventBus;

/**
 * It's a very simple Event Dispatcher.
 */
class EventBus
{
    private $handlers;
    private $logger;

    public function __construct($logger)
    {
        $this->handlers = array();
        $this->logger = $logger;
    }

    /**
     * Associate a Listener to an Event by its name (as defined by Event->getName()).
     *
     * @param string       $eventName
     * @param EventHandler $listener
     */
    public function addListener($eventName, EventHandler $handler)
    {
        $this->handlers[$eventName][] = $handler;
    }

    /**
     * Associates a Listener to an array of Events. In case one Listener should respond to several events.
     *
     * @param EventHandler $subscriber
     * @param array        $events
     */
    public function subscribeListener(EventHandler $subscriber, array $events)
    {
        foreach ($events as $event) {
            $this->addListener($event, $subscriber);
        }
    }

    /**
     * Dispatches an arbitrary Event to Listenters. The event could be handled by a Listener or simply ignored if no listener can handle it.
     *
     * @param Event $event
     */
    public function dispatch(Event $event)
    {
        if (!$this->canManageEvent($event)) {
            return;
        }
        foreach ($this->handlers[$event->getName()] as $handler) {
            $this->logger->info(sprintf('Event %s dispatched to Handler %s.', $event->getName(), get_class($handler)));
            $handler->handle($event);
        }
    }

    private function canManageEvent(Event $event)
    {
        if (isset($this->handlers[$event->getName()])) {
            return true;
        }
        $this->logger->notice(sprintf('Event %s can not be handled', $event->getName()));
    }

    public function addListeners($eventName, $handlers)
    {
        foreach ($handlers as $handler) {
            $this->addListener($eventName, $handler);
        }
    }
}
