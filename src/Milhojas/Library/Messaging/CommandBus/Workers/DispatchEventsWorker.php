<?php

namespace Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;

/**
 * Collects events and dispatches them
 * Must be at the end of the chain.
 */
class DispatchEventsWorker extends CommandWorker
{
    private $eventBus;
    private $recorder;

    public function __construct(EventBus $eventBus, EventRecorder $recorder)
    {
        $this->eventBus = $eventBus;
        $this->recorder = $recorder;
    }

    public function execute(Command $command)
    {
        foreach ($this->recorder as $event) {
            $this->eventBus->dispatch($event);
        }
        $this->recorder->flush();
    }
}
