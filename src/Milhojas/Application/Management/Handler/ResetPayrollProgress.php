<?php

namespace Milhojas\Application\Management\Handler;

use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

/**
 * Resets Payroll Distribution Progress exchange file.
 */
class ResetPayrollProgress implements Listener
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle(Event $event)
    {
        file_put_contents($this->file, json_encode([]));
    }
}
