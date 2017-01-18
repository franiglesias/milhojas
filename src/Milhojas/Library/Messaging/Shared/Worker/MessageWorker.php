<?php

namespace Milhojas\Library\Messaging\Shared\Worker;

use Milhojas\Library\Messaging\Shared\Message;

abstract class MessageWorker
{
    protected $next;

    abstract public function execute(Message $message);

    /**
     * Processes the command and pass it along to the next worker in the chain.
     *
     * @param Message $message
     */
    final public function work(Message $message)
    {
        $this->execute($message);
        $this->delegate($message);
    }

    /**
     * Sets the following worker in the chain.
     *
     * @param MessageWorker $next
     */
    public function chain(MessageWorker $next)
    {
        if (!$this->next) {
            $this->next = $next;

            return;
        }
        $this->next->chain($next);
    }

    /**
     * Pass the command to the next Worker in the chain.
     *
     * @param Message $message
     */
    protected function delegate(Message $message)
    {
        if (!$this->next) {
            return;
        }
        $this->next->work($message);
    }
}
