<?php

namespace Milhojas\Library\Messaging\Shared\Pipeline;

use Milhojas\Library\Messaging\Shared\Message;

/**
 * A pipeline of MessageWorkers.
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
