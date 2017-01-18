<?php

namespace spec\Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Listener;
use PhpSpec\ObjectBehavior;

class EventBusSpec extends ObjectBehavior
{
    public function let(\Psr\Log\LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(EventBus::class);
    }

    public function it_can_add_a_listener_to_handle_an_event(Listener $eventHandler, Event $event)
    {
        $this->addListener('some.event', $eventHandler);
        $event->getName()->willReturn('some.event');
        $eventHandler->handle($event)->shouldBeCalled();
        $this->dispatch($event);
    }

    public function it_does_nothing_when_dispatching_a_not_managed_event(Listener $eventHandler, Event $event)
    {
        $this->addListener('some.event', $eventHandler);
        $event->getName()->willReturn('another.event');
        $eventHandler->handle($event)->shouldNotBeCalled();
        $this->dispatch($event);
    }

    public function it_can_add_several_listeners_to_the_same_event(Listener $eventHandler1, Listener $eventHandler2, Event $event)
    {
        $this->addListener('some.event', $eventHandler1);
        $this->addListener('some.event', $eventHandler2);
        $event->getName()->willReturn('some.event');
        $eventHandler1->handle($event)->shouldBeCalled();
        $eventHandler2->handle($event)->shouldBeCalled();
        $this->dispatch($event);
    }

    public function it_dispatches_to_the_right_handler(Listener $eventHandler1, Listener $eventHandler2, Event $event)
    {
        $this->addListener('some.event', $eventHandler1);
        $this->addListener('another.event', $eventHandler2);
        $event->getName()->willReturn('some.event');
        $eventHandler1->handle($event)->shouldBeCalled();
        $eventHandler2->handle($event)->shouldNotBeCalled();
        $this->dispatch($event);
    }

    public function it_can_add_several_listeners_on_one_call(Listener $eventHandler1, Listener $eventHandler2, Event $event)
    {
        $this->addListeners('some.event', [$eventHandler1, $eventHandler2]);
        $event->getName()->willReturn('some.event');
        $eventHandler1->handle($event)->shouldBeCalled();
        $eventHandler2->handle($event)->shouldBeCalled();
        $this->dispatch($event);
    }
}
