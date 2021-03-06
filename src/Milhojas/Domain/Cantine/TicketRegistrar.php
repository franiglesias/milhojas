<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Utils\Schedule\ListOfDates;

class TicketRegistrar
{
    private $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function register(CantineUser $cantineUser, ListOfDates $listOfDates)
    {
        foreach ($listOfDates as $date) {
            $this->ticketRepository->store(new Ticket($cantineUser, $date));
        }
    }
}
