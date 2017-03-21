<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 21/3/17
 * Time: 9:52
 */

namespace tests\Application\Utils;


use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\EventBus;
use Milhojas\Messaging\Shared\Worker\Worker;
use Traversable;


class TestEventBus extends EventBus implements \IteratorAggregate
{
    private $events;

    public function __construct()
    {
        $this->events = [];
    }

    public function dispatch(Event $event)
    {
        $this->events[] = get_class($event);
    }

    public function wasDispatched($eventName)
    {
        return in_array($eventName, $this->events);
    }

    public function getHistory()
    {
        return $this->events;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }
}
