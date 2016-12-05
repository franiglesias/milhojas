<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Library\EventBus\Event;

/**
 * Notifies to Listeners that a Cantine User bought one or more tickets
 */
class CantineUserBoughtTickets implements Event
{
    private $user;
    private $dates;
    /**
     * @param CantineUser $user that bought tickets
     * @param ListOfDates $dates for which the tickets were bought
     */
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
