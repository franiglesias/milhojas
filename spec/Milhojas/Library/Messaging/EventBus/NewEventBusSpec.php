<?php

namespace spec\Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\NewEventBus;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use PhpSpec\ObjectBehavior;

class NewEventBusSpec extends ObjectBehavior
{
    public function let(MessageWorker $worker1, MessageWorker $worker2, MessageWorker $worker3)
    {
        $worker1->chain($worker2)->shouldBeCalled();
        $worker1->chain($worker3)->shouldBeCalled();
        $this->beConstructedWith([$worker1, $worker2, $worker3]);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(NewEventBus::class);
    }

    public function it_dispatches_events_through_the_workers(Event $event, $worker1, $worker2, $worker3)
    {
        $worker1->work($event)->shouldBeCalled();
        $this->dispatch($event);
    }
}
