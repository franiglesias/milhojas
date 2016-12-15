<?php

namespace Milhojas\Domain\Cantine\Specification;

use League\Period\Period;
use Milhojas\Domain\Cantine\Ticket;

class TicketSoldInMonth extends TicketSpecification
{
    private $period;

    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        return $this->filterTicket($ticket) && $ticket->belongsToPeriod($this->period);
    }
}
