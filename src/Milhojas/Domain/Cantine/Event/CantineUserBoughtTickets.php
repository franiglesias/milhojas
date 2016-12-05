<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Library\EventBus\Event;

class CantineUserBoughtTickets implements Event
{
    private $user;
    private $dates;
    public function __construct(CantineUser $user, ListOfDates $dates)
    {
        $this->user = $user;
        $this->dates = $dates;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDates()
    {
        return $this->dates;
    }/**
     * @inheritDoc
     */
    public function getName()
    {
        return 'milhojas.cantine.cantine_user_bought_tickets';
    }
}
