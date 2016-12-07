<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\TicketSpecification;

class TicketCounter
{
    private $ticketRepository;
    private $price;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function incomeOnDate(\DateTime $date)
    {
        return $this->price * $this->soldOnDate($date);
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function count(TicketSpecification $ticketSpecification)
    {
        return $this->ticketRepository->count($ticketSpecification);
    }

    public function income(TicketSpecification $ticketSpecification)
    {
        return $this->price * $this->count($ticketSpecification);
    }
}
