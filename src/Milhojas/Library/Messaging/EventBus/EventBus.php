<?php

namespace Milhojas\Library\Messaging\EventBus;

/**
 * EventBus dispatches Events to Listeners
 */
interface EventBus
{
    /**
     * Dispatches an arbitrary Event to Listenters. The event could be handled by a Listener or simply ignored if no listener can handle it.
     * @param Event $event
     */
    public function dispatch(Event $event);
    /**
     * Associate a Listener to an Event by its name (as defined by Event->getName())
     * @param string        $eventName
     * @param EventHandler $listener
     */
    public function addListener($eventName, EventHandler $listener);

    /**
     * Associates a Listener to an array of Events. In case one Listener should respond to several events
     * @param EventHandler $subscriber
     * @param array        $events
     */

    public function subscribeListener(EventHandler $subscriber, array $events);
}
