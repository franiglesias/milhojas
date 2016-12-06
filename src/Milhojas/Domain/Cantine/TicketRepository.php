<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\TicketSpecification;

interface TicketRepository
{
    /**
     * Store a Ticket.
     *
     * @param Ticket $ticket
     */
    public function store(Ticket $ticket);
    /**
     * Counts tickets given a Specification.
     *
     * @param TicketSpecification $ticketSpecification
     */
    public function count(TicketSpecification $ticketSpecification);
}
