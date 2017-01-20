<?php

namespace Milhojas\Application\Cantine\Listener;

use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Listener;
use Milhojas\Domain\Cantine\TicketRegistrar;

class RegisterBoughtTickets implements Listener
{
    private $registrar;

    public function __construct(TicketRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->registrar->register($event->getUser(), $event->getDates());
    }
}
