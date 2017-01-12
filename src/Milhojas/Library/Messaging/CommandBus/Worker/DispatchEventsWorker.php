<?php

namespace Milhojas\Library\Messaging\CommandBus\Worker;

use Doctrine\Common\Cache\ChainCache;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;

/**
 * Collects events and dispatches them
 * Must be at the end of the chain.
 */
class DispatchEventsWorker extends CommandWorker
{
    /**
     * Needed to dispatch events.
     *
     * @var EventBus
     */
    private $eventBus;
    /**
     * Collect events to dispatch.
     *
     * @var mixed
     */
    private $recorder;

    public function __construct(EventBus $eventBus, EventRecorder $recorder)
    {
        $this->eventBus = $eventBus;
        $this->recorder = $recorder;
    }

    /**
     * Dispatches events collected in EventRecorder.
     *
     * @param Command $command
     */
    public function execute(Command $command)
    {
        foreach ($this->recorder as $event) {
            $this->eventBus->dispatch($event);
        }
        $this->recorder->flush();
    }

    /**
     * Forces this Worker to be the last in the workers ChainCache.
     *
     * @throws \InvalidArgumentException [description]
     */
    public function setNext(CommandWorker $worker)
    {
        throw new \InvalidArgumentException('DispatchEventsWorker should be the last worker in the chain');
    }
}
