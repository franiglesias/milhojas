<?php

namespace spec\Milhojas\Library\Messaging\CommandBus\Command;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\CommandBus\Command\BroadcastEvent;
use Milhojas\Library\Messaging\CommandBus\Command\BroadcastEventHandler;
use Milhojas\Library\Messaging\EventBus\EventRecorder;
use PhpSpec\ObjectBehavior;

class BroadcastEventHandlerSpec extends ObjectBehavior
{
    public function let(EventRecorder $eventRecorder)
    {
        $this->beConstructedWith($eventRecorder);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(BroadcastEventHandler::class);
    }

    public function it_handles_BroadcastEvent_commands(BroadcastEvent $broadcastEvent, $eventRecorder, Event $event)
    {
        $broadcastEvent->getEvent()->shouldBeCalled()->willReturn($event);
        $eventRecorder->recordThat($event)->shouldBeCalled();
        $this->handle($broadcastEvent);
    }
}
