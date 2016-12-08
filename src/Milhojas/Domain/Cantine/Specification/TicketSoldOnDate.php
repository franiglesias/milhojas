<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;

/**
 * Selects Tickets sold on a concrete date.
 */
class TicketSoldOnDate extends TicketSpecification
{
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
        $this->filter = 'all';
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        $diff = $this->date->diff($ticket->getDate());

        return $this->filterTicket($ticket) && $diff->format('%d') == 0;
    }
}
