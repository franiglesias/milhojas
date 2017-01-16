<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Domain\Cantine\Turn;
use Milhojas\Domain\Cantine\CantineUser;

class UserWasAssignedToCantineTurn implements Event
{
    private $user;
    private $turn;
    private $date;

    public function __construct(CantineUser $cantineUser, Turn $turn, \DateTimeInterface $date)
    {
        $this->user = $cantineUser;
        $this->turn = $turn;
        $this->date = $date;
    }
    /**
     * @return
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cantine.user_was_assigned_to_cantine_turn.event';
    }
}
