<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;

class TicketSoldOnDate implements TicketSpecification
{
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Ticket $ticket)
    {
        $diff = $this->date->diff($ticket->getDate());

        return $diff->format('%d') == 0;
    }
}
