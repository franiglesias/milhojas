<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Library\ValueObjects\Dates\MonthYear;

class TicketSoldInMonth extends TicketSpecification
{
    private $month;

    public function __construct(MonthYear $month)
    {
        $this->month = $month;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        return $this->filterTicket($ticket) && $ticket->belongsToMonth($this->month);
    }
}
