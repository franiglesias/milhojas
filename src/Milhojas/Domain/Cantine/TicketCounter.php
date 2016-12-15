<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\TicketSpecification;
use Milhojas\Domain\Cantine\DTO\TicketCountResult;

/**
 * Counts tickets in ticket Repository
 */
class TicketCounter
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;
    /**
     * @var float Price for this count
     */
    private $price;

    /**
     * @param TicketRepository $ticketRepository
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     *
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param TicketSpecification $ticketSpecification
     */
    public function count(TicketSpecification $ticketSpecification)
    {
        $total = $this->countSold($ticketSpecification->all());
        $paid = $this->countSold($ticketSpecification->onlyPaid());

        return new TicketCountResult($this->price, $paid, $total);
    }

    /**
     * @param TicketSpecification $ticketSpecification
     */
    private function countSold(TicketSpecification $ticketSpecification)
    {
        return $this->ticketRepository->count($ticketSpecification);
    }
}
