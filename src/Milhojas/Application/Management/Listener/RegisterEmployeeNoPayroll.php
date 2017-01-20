<?php

namespace Milhojas\Application\Management\Listener;

use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Messaging\EventBus\Event;

class RegisterEmployeeNoPayroll implements Listener
{
    private $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle(Event $event)
    {
        $employee = $event->getEmployee();
        $name = $employee->getFullName();
        file_put_contents($this->file, $name.chr(10), FILE_APPEND);
    }
}
