<?php

namespace Tests\Library\Messaging\EventBus\Utils;

use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Listener;

/**
 * Description.
 */
class EventBusSpy implements EventBus
{
    private $busUnderTest;
    private $recordedHandlers;
    public function __construct(EventBus $busUnderTest)
    {
        $this->busUnderTest = $busUnderTest;
        $this->recordedHandlers = array();
    }

    private function extract()
    {
        $reflect = new \ReflectionObject($this->busUnderTest);
        $property = $reflect->getProperty('handlers');
        $property->setAccessible(true);
        $handlers = $property->getValue($this->busUnderTest);

        return $handlers;
    }

    public function recordHandler($event, $handler)
    {
        $this->recordedHandlers[$event->getName()][] = $handler;
    }

    public function dispatch(Event $event)
    {
        $this->busUnderTest->dispatch($event);
    }

    public function subscribeListener(Listener $subscriber, array $events)
    {
        $this->busUnderTest->subscribeListener($subscriber, $events);
    }

    public function addListener($eventName, Listener $handler)
    {
        $this->busUnderTest->addListener($eventName, $handler);
    }

    public function assertWasRegistered($eventName, Listener $handler)
    {
        $handlers = $this->extract();
        foreach ($handlers[$eventName] as $test) {
            if ($test == $handler) {
                return true;
            }
        }

        return false;
    }

    public function eventWasHandled($eventName)
    {
        return in_array($eventName, $this->getHandledEvents());
    }

    public function getHandledEvents()
    {
        return array_keys($this->recordedHandlers);
    }

    public function getRecordedHandlers()
    {
        return $this->recordedHandlers;
    }
}
