<?php

namespace spec\Milhojas\Library\Messaging\EventBus\Loader;

use Milhojas\Library\Messaging\EventBus\Listener;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Loader\ListenerLoader;
use Milhojas\Library\Messaging\Shared\Exception\InvalidLoaderKey;
use PhpSpec\ObjectBehavior;

class ListenerLoaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListenerLoader::class);
    }

    public function it_can_add_a_listener_to_handle_an_event(Listener $listener)
    {
        $this->addListener('some.event', $listener);
        $this->get('some.event')->shouldBe([$listener]);
    }

    public function it_can_add_several_listeners_at_a_time_to_the_same_event(Listener $listener1, Listener $listener2, Listener $listener3)
    {
        $this->addListeners('some.event', [$listener1, $listener2, $listener3]);
        $this->get('some.event')->shouldBe([$listener1, $listener2, $listener3]);
    }

    public function it_throws_exception_if_it_can_not_manage_event()
    {
        $this->shouldThrow(InvalidLoaderKey::class)->during('get', ['unmanaged.event']);
    }
}