<?php

namespace Milhojas\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;

/**
 * Base class for Chainable Command Workers. Manages the next pointer and encapsulates delegation.
 *
 * @author Francisco Iglesias Gómez
 */
abstract class CommandWorker
{
    protected $next;

    abstract public function execute(Command $command);

    /**
     * Processes the command and pass it along to the next worker in the chain.
     *
     * @param Command $command
     */
    final public function work(Command $command)
    {
        $this->execute($command);
        $this->delegateNext($command);
    }

    /**
     * Sets the following worker in the chain.
     *
     * @param CommandWorker $next
     */
    public function setNext(CommandWorker $next)
    {
        if (!$this->next) {
            $this->next = $next;

            return;
        }
        $this->next->setNext($next);
    }

    /**
     * Pass the command to the next Worker in the chain.
     *
     * @param Command $command
     */
    protected function delegateNext(Command $command)
    {
        if (!$this->next) {
            return;
        }
        $this->next->execute($command);
    }
}
