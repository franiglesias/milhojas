<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;

class TicketSoldInMonth implements TicketSpecification
{
    private $month;

    public function __construct($month)
    {
        $this->month = ucfirst(strtolower($month));
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        return $ticket->belongsToMonth($this->month);
    }
}
