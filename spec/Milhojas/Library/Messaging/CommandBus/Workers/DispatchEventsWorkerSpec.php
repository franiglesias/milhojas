<?php

namespace spec\Milhojas\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Worker\CommandWorker;
use Milhojas\Library\Messaging\CommandBus\Worker\DispatchEventsWorker;
use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;
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
    }

    public function it_forces_to_be_the_last_one_worker_by_throwing_an_exception(CommandWorker $worker)
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('setNext', [$worker]);
    }

    public function it_dispatches_events($eventBus, $recorder, Event $event1, Event $event2, Command $command)
    {
        $recorder->getIterator()->shouldBeCalled()->willReturn(new \ArrayIterator([$event1->getWrappedObject(), $event2->getWrappedObject()]));
        $eventBus->dispatch(Argument::type(Event::class))->shouldBeCalled(2);
        $recorder->flush()->shouldBeCalled();
        $this->execute($command);
    }
}
