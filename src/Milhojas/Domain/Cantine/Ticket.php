<?php

namespace Milhojas\Domain\Cantine;

class Ticket
{
    private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }
}
