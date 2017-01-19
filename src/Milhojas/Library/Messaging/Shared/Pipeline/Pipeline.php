<?php

namespace Milhojas\Library\Messaging\Shared\Pipeline;

use Milhojas\Library\Messaging\Shared\Message;

/**
 * Acts ad the MessageBus execution engine.
 */
interface Pipeline
{
    /**
     * Executes the pipeline passing the $message to all the workers in order.
     *
     * @param Message $message
     *
     * @return mixed null for Command and Event, the Response for Query
     */
    public function work(Message $message);
}
