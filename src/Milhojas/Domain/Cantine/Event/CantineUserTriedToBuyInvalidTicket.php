<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Messaging\EventBus\Event;

class CantineUserTriedToBuyInvalidTicket implements Event
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cantine.cantine_user_tried_to_buy_invalid_ticket.event';
    }
}
