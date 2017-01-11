<?php

namespace Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\CommandBus\Command;

/**
 * Base class for Chainable Command Workers. Manages the next pointer and encapsulates delegation.
 *
 * @author Francisco Iglesias Gómez
 */
abstract class CommandWorker
{
    protected $next;

    public function setNext(ChainableCommandWorker $next)
    {
        $this->next = $next;
    }

    protected function delegateNext(Command $command)
    {
        if (!$this->next) {
            return;
        }
        $this->next->execute($command);
    }
}
