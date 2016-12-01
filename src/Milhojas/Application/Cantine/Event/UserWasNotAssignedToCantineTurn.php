<?php

namespace Milhojas\Application\Cantine\Event;

use Milhojas\Library\EventBus\Event;

class UserWasNotAssignedToCantineTurn implements Event
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'milhojas.cantine.user_was_not_assigned_to_cantine_turn';
    }
}
