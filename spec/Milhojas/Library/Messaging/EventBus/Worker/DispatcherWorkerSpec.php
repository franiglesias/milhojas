<?php

namespace spec\Milhojas\Library\Messaging\EventBus\Worker;

use Milhojas\Library\Messaging\EventBus\Loader\ListenerLoader;
use Milhojas\Library\Messaging\EventBus\Worker\DispatcherWorker;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Listener;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;

class DispatcherWorkerSpec extends ObjectBehavior
{
    public function let(ListenerLoader $loader)
    {
        $this->beConstructedWith($loader);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(DispatcherWorker::class);
        $this->shouldBeAnInstanceOf(MessageWorker::class);
    }

    public function it_dispatches_event_to_one_handler(Event $event, Listener $listener, $loader)
    {
        $event->getName()->shouldBeCalled()->willReturn('event');
        $loader->get('event')->shouldBeCalled()->willReturn([$listener]);
        $listener->handle($event)->shouldBeCalled();
        $this->work($event);
    }

    public function it_dispatches_event_to_several_handlers(Event $event, Listener $listener, Listener $listener2, $loader)
    {
        $event->getName()->shouldBeCalled()->willReturn('event');
        $loader->get('event')->shouldBeCalled()->willReturn([$listener, $listener2]);
        $listener->handle($event)->shouldBeCalled();
        $listener2->handle($event)->shouldBeCalled();
        $this->work($event);
    }
}
