<?php

namespace spec\Milhojas\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\NewEventBus;
use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;
use PhpSpec\ObjectBehavior;

class NewEventBusSpec extends ObjectBehavior
{
    public function let(Pipeline $pipeline)
    {
        $this->beConstructedWith($pipeline);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(NewEventBus::class);
    }

    public function it_dispatches_events_through_the_pipeline(Event $event, $pipeline)
    {
        $pipeline->work($event)->shouldBeCalled();
        $this->dispatch($event);
    }
}
