<?php

namespace spec\Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\CommandBus\Workers\CommandWorker;
use Milhojas\Library\Messaging\CommandBus\Workers\DispatchEventsWorker;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;
use PhpSpec\ObjectBehavior;

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

    public function it_forces_to_be_the_last_one_worker(CommandWorker $worker)
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('setNext', [$worker]);
    }
}
