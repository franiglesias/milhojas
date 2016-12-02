<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\TicketRepository;
use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Cantine\Specification\TicketSpecification;

class TicketInMemoryRepository implements TicketRepository
{
    private $tickets = [];
    /**
     * {@inheritdoc}
     */
    public function store(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    public function countSatisfying(TicketSpecification $ticketSpecification)
    {
        $count = 0;
        foreach ($this->tickets as $ticket) {
            if ($ticketSpecification->isSatisfiedBy($ticket)) {
                ++$count;
            }
        }

        return $count;
    }
}
