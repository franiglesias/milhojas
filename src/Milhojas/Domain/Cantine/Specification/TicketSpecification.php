<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Ticket;

abstract class TicketSpecification
{
    const PAID = 'paid';
    const PENDING = 'pending';
    const ALL = 'all';
    protected $filter = self::ALL;

    abstract public function isSatisfiedBy(Ticket $ticket);

    /**
     * [Short description of the method].
     *
     * @param Ticket $ticket [Description]
     *
     * @return [type]
     */
    public function filterTicket(Ticket $ticket)
    {
        switch ($this->filter) {
            case self::PAID:
                $filter = $ticket->isPaid() ? true : false;
                break;
            case self::PENDING:
                $filter = $ticket->isPaid() ? false : true;
                break;
            default:
                $filter = true;
                break;
        }

        return $filter;
    }

    public function onlyPaid()
    {
        $this->filter = self::PAID;

        return $this;
    }
    public function onlyPending()
    {
        $this->filter = self::PENDING;

        return $this;
    }
    public function all()
    {
        $this->filter = self::ALL;

        return $this;
    }
}
