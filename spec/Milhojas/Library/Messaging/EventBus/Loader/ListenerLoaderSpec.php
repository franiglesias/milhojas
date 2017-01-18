<?php

namespace spec\Milhojas\Library\Messaging\EventBus\Loader;

use Milhojas\Library\Messaging\EventBus\Listener;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Loader\ListenerLoader;
use PhpSpec\ObjectBehavior;

class ListenerLoaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListenerLoader::class);
    }

    public function it_can_add_a_listener_to_handle_an_event(Listener $eventHandler, Event $event)
    {
        $this->addListener('some.event', $eventHandler);
        $this->get('some.event')->shouldBe([$eventHandler]);
    }
}
