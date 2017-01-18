<?php

namespace Milhojas\Library\Messaging\Shared\Worker;

use Milhojas\Library\Messaging\Shared\Message;

abstract class MessageWorker
{
    protected $next;
    protected $result;

    abstract public function execute(Message $message);

    /**
     * Processes the command and pass it along to the next worker in the chain.
     *
     * @param Message $message
     */
    public function work(Message $message)
    {
        $result = $this->execute($message);
        if ($result && !$this->result) {
            $this->result = $result;
        }

        return $this->delegate($message);
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
            return $this->result;
        }

        return $this->next->work($message);
    }
}
