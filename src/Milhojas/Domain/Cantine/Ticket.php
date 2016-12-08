<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Library\ValueObjects\Dates\MonthYear;

class Ticket
{
    private $date;
    private $user;
    private $paid;

    public function __construct(CantineUser $user, \DateTime $date, $paid = false)
    {
        $this->user = $user;
        $this->date = $date;
        $this->paid = $paid;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function belongsToMonth(MonthYear $month)
    {
        return $month->dateBelongsToMe($this->date);
    }

    public function isPaid()
    {
        return $this->paid;
    }

    public function pay()
    {
        $this->paid = true;
    }
}
