<?php

namespace spec\Milhojas\Library\Messaging\Shared\Worker;

use Milhojas\Library\Messaging\Shared\Message;
use Milhojas\Library\Messaging\Shared\Worker\DispatchEventsWorker;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DispatchEventsWorkerSpec extends ObjectBehavior
{
    public function let(EventBus $eventBus, EventRecorder $recorder)
    {
        $this->beConstructedWith($eventBus, $recorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(DispatchEventsWorker::class);
        $this->shouldBeAnInstanceOf(MessageWorker::class);
    }

    public function it_is_forced_to_be_the_last_one_worker(MessageWorker $worker, Message $message)
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('chain', [$worker]);
    }

    public function it_dispatches_events($eventBus, $recorder, Event $event1, Event $event2, Message $message)
    {
        $recorder->getIterator()->shouldBeCalled()->willReturn(new \ArrayIterator([$event1->getWrappedObject(), $event2->getWrappedObject()]));
        $eventBus->dispatch(Argument::type(Event::class))->shouldBeCalled(2);
        $recorder->flush()->shouldBeCalled();
        $this->work($message);
    }
}