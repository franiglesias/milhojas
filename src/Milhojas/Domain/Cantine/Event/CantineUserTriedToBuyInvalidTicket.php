<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Library\EventBus\Event;

class CantineUserTriedToBuyInvalidTicket implements Event
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'milhojas.cantine.cantine_user_tried_to_buy_invalid_ticket';
    }
}
