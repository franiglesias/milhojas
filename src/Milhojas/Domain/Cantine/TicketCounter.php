<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\DTO\TicketCountResult;

class TicketCounter
{
    private $ticketRepository;
    private $price;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
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
        $total = $this->countSold($ticketSpecification->all());
        $paid = $this->countSold($ticketSpecification->onlyPaid());

        return new TicketCountResult($this->price, $paid, $total);
    }

    private function countSold(TicketSpecification $ticketSpecification)
    {
        return $this->ticketRepository->count($ticketSpecification);
    }
}
