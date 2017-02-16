<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Shared\StudentId;

class TicketSoldToStudent extends TicketSpecification
{
    private $studentId;
    public function __construct($id)
    {
        $this->studentId = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        return $this->filterTicket($ticket) && $ticket->getUserId() == $this->studentId;
    }
}
