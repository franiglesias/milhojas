<?php

namespace Milhojas\Application\Cantine\Event;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Domain\Cantine\CantineUser;

class UserWasNotAssignedToCantineTurn implements Event
{
    private $user;
    private $date;

    public function __construct(CantineUser $cantineUser, \DateTimeInterface $date)
    {
        $this->user = $cantineUser;
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'milhojas.cantine.user_was_not_assigned_to_cantine_turn';
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getdate()
    {
        return $this->date;
    }
}
