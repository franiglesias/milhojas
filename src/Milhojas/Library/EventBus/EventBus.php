<?php

namespace Milhojas\Library\EventBus;

interface EventBus
{
    public function dispatch(Event $event);
    public function addListener($eventName, EventHandler $listener);
    public function subscribeListener(EventHandler $subscriber, array $events);
}
