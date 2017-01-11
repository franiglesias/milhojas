<?php

namespace Milhojas\Application\Cantine\Listener;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\EventHandler;
use Milhojas\Domain\Cantine\TicketRegistrar;

class RegisterBoughtTickets implements EventHandler
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
