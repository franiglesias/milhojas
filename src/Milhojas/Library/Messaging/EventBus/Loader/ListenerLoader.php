<?php

namespace Milhojas\Library\Messaging\EventBus\Loader;

class ListenerLoader
{
    private $listeners = [];

    public function addListener($event_name, $listener)
    {
        $this->listeners[$event_name][] = $listener;
    }

    public function get($event_name)
    {
        return $this->listeners[$event_name];
    }
}
