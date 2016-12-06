<?php

namespace Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Cantine\Specification\TicketSoldInMonth;
use Milhojas\Domain\School\StudentId;
use Milhojas\Infrastructure\Persistence\Cantine\TicketInMemoryRepository;
use Milhojas\Library\EventBus\EventBus;
use Prophecy\Prophet;

/**
 * Defines application features from the specific context.
 */
class TicketAccountingContext implements Context
{
    private $eventBus;
    private $prophet;
    private $ticketRepository;
    private $ticketCounter;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->prophet = new Prophet();

        $eventBus = $this->prophet->prophesize(EventBus::class);
        $this->eventBus = $eventBus->reveal();
        $this->ticketRepository = new TicketInMemoryRepository();
        $this->ticketCounter = new TicketCounter($this->ticketRepository);
    }

    /**
     * @Given We have tickets registered
     */
    public function weHaveTicketsRegistered(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $user = $this->prophet->prophesize(CantineUser::class);
            $user->getStudentId()->willReturn(new StudentId($row['user']));
            $ticket = new Ticket($user->reveal(), new \DateTime($row['date']));
            $this->ticketRepository->store($ticket);
        }
    }

    /**
     * @When We count items for date :date
     */
    public function weCountItemsForDate($date)
    {
        $this->date = $date;
        $this->sold = $this->ticketCounter->soldOnDate($date);
    }

    /**
     * @Given Every ticket costs :ticketPrice €
     */
    public function everyTicketCostsEu($ticketPrice)
    {
        $this->ticketCounter->setPrice($ticketPrice);
    }

    /**
     * @Then Total tickets sold should be :tickets
     */
    public function totalTicketsSoldShouldBe($tickets)
    {
        if ((int) $tickets !== $this->sold) {
            throw new \Exception('Ticket count does not match');
        }
    }

    /**
     * @Then Total income should be :income €
     */
    public function totalIncomeShouldBeEu($income)
    {
        if ((float) $income !== $this->ticketCounter->incomeOnDate($this->date)) {
            throw new \Exception('Ticket count does not match');
        }
    }

    /**
     * @When We account tickets for month :month
     */
    public function weAccountTicketsForMonth($month)
    {
        $this->sold = $this->ticketRepository->count(new TicketSoldInMonth($month));
    }
}
