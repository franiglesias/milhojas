<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;

interface TicketSpecification
{
    public function isSatisfiedBy(Ticket $ticket);
}
