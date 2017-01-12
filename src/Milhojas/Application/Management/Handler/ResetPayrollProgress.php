<?php

namespace Milhojas\Application\Management\Handler;

use Milhojas\Library\Messaging\EventBus\EventHandler;
use Milhojas\Library\Messaging\EventBus\Event;

/**
 * Resets Payroll Distribution Progress exchange file.
 */
class ResetPayrollProgress implements EventHandler
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
