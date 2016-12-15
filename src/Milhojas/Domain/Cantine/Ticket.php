<?php

namespace Milhojas\Domain\Cantine;

use League\Period\Period;

class Ticket
{
    private $date;
    private $user;
    private $paid;

    public function __construct(CantineUser $user, \DateTimeInterface $date, $paid = false)
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

    public function getUserId()
    {
      return $this->user->getStudentId();
    }

    public function isPaid()
    {
        return $this->paid;
    }

    public function pay()
    {
        $this->paid = true;
    }

    public function belongsToPeriod(Period $period)
    {
        return $period->contains($this->date);
    }
}
