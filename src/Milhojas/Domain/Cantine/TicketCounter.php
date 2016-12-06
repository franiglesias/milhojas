<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;

class TicketCounter
{
    private $ticketRepository;
    private $price;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function soldOnDate(\DateTime $date)
    {
        return $this->ticketRepository->count(new TicketSoldOnDate($date));
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
}
