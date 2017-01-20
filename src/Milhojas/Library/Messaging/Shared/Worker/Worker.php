<?php

namespace Milhojas\Library\Messaging\Shared\Worker;

use Milhojas\Library\Messaging\Shared\Message;

interface Worker
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
