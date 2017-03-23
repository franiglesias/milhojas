<?php

namespace Milhojas\Application\Management\Listener;

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Listener;


class ArchiveSentPayrolls implements Listener
{
    /**
     * @var Payrolls
     */
    private $payrolls;

    public function __construct(Payrolls $payrolls)
    {
        $this->payrolls = $payrolls;
    }

    public function handle(Event $event)
    {
        $employee = $event->getEmployee();
        $month = $event->getMonth();
        $this->payrolls->archive($employee, $month);
    }
}
