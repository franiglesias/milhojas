<?php

namespace Milhojas\Domain\Cantine\DTO;

class TicketCountResult
{
    private $price = 0;
    private $total = 0;
    private $paid = 0;

    public function __construct($ticketPrice, $paid, $total)
    {
        $this->price = $ticketPrice;
        $this->paid = $paid;
        $this->total = $total;
    }

    public function getTotalCount()
    {
        return $this->total;
    }

    public function getTotalIncome()
    {
        return $this->total * $this->price;
    }

    public function getPendingCount()
    {
        return $this->total - $this->paid;
    }

    public function getPaidCount()
    {
        return $this->paid;
    }

    public function getPaidIncome()
    {
        return $this->price * $this->paid;
    }

    public function getPendingIncome()
    {
        return $this->getPendingCount() * $this->price;
    }
}
