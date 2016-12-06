<?php

namespace Milhojas\Domain\Cantine;

class Ticket
{
    private $date;
    private $user;

    public function __construct(CantineUser $user, \DateTime $date)
    {
        $this->user = $user;
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function belongsToMonth($month)
    {
        return $this->date->format('F') == $month;
    }
}
