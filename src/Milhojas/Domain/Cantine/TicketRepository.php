<?php

namespace Milhojas\Domain\Cantine;

interface TicketRepository
{
    public function store(Ticket $ticket);
}
