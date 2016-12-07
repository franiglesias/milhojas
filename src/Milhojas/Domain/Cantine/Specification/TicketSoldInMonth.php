<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Library\ValueObjects\Dates\MonthYear;

class TicketSoldInMonth implements TicketSpecification
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
        return $ticket->belongsToMonth($this->month);
    }
}
