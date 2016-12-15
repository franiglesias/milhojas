<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Cantine\Specification\TicketSoldOnDate;
use Milhojas\Domain\Cantine\Specification\TicketSoldInMonth;
use Milhojas\Domain\Cantine\Ticket;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\TicketCounter;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Infrastructure\Persistence\Cantine\TicketInMemoryRepository;
use Milhojas\Library\EventBus\EventBus;
use Prophecy\Prophet;
use League\Period\Period;

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

// Background section

    /**
     * @Given We have tickets registered
     */
    public function weHaveTicketsRegistered(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $user = $this->prophet->prophesize(CantineUser::class);
            $user->getStudentId()->willReturn(new StudentId($row['user']));
            $ticket = new Ticket($user->reveal(), new \DateTime($row['date']), ($row['paid'] == 'yes'));
            $this->ticketRepository->store($ticket);
        }
    }

    /**
     * @Given Every ticket costs :ticketPrice €
     */
    public function everyTicketCostsEu($ticketPrice)
    {
        $this->ticketCounter->setPrice($ticketPrice);
    }

// Given section

// When section

    /**
     * @When We count items for date :date
     */
    public function weCountItemsForDate($date)
    {
        $this->date = $date;
        $this->result = $this->ticketCounter->count(new TicketSoldOnDate($date));
    }

// Then section

    /**
     * @When We account tickets for month :month
     */
    public function weAccountTicketsForMonth($month)
    {
        $this->result = $this->ticketCounter->count(new TicketSoldInMonth($month));
    }

    /**
     * @Then Total tickets sold should be :tickets
     */
    public function totalTicketsSoldShouldBe($tickets)
    {
        if ((int) $tickets !== $this->result->getTotalCount()) {
            throw new \Exception(sprintf('Ticket count does not match %s != %s', $tickets, $this->result->getTotalCount()));
        }
    }

    /**
     * @Then Total income should be :income €
     */
    public function totalIncomeShouldBeEu($income)
    {
        if ((float) $income !== $this->result->getTotalIncome()) {
            throw new \Exception('Income does not match');
        }
    }

    /**
     * @Then Pending tickets should be :pendingTickets
     */
    public function pendingTicketsShouldBe($pendingTickets)
    {
        if ((int) $pendingTickets !== $this->result->getPendingCount()) {
            throw new \Exception(sprintf('Ticket count does not match %s != %s', $pendingTickets, $this->result->getPendingCount()));
        }
    }

    /**
     * @Then Pending income should be :pendingIncome €
     */
    public function pendingIncomeShouldBeEu($pendingIncome)
    {
        if ((float) $pendingIncome !== $this->result->getPendingIncome()) {
            throw new \Exception('Pending income does not match');
        }
    }

    /**
     * @Then Paid tickets should be :paidTickets
     */
    public function paidTicketsShouldBe($paidTickets)
    {
        if ((int) $paidTickets !== $this->result->getPaidCount()) {
            throw new \Exception('Paid ticket count does not match');
        }
    }

    /**
     * @Then Paid income should be :paidIncome €
     */
    public function paidIncomeShouldBeEu($paidIncome)
    {
        if ((float) $paidIncome !== $this->result->getPaidIncome()) {
            throw new \Exception('Paid income does not match');
        }
    }

    /**
     * @When We bill :student for pending tickets
     */
    public function weBillForPendingTickets($student)
    {
        $this->result = $this->ticketCounter->count(new TicketSoldToStudent(new StudentId()));
    }

    /**
     * @When We generate a report for month :month
     */
    public function weGenerateAReportForMonth($month)
    {
        $this->report = $this->ticketRepository->find((new TicketSoldInMonth($month))->onlyPending());
    }

    /**
     * @Then Whe should get a list like this
     */
    public function wheShouldGetAListLikeThis(TableNode $table)
    {

        throw new PendingException();
    }

    /**
     * @Transform :month
     */
    public function castMonthToPeriod($month)
    {
        list($month, $year) = explode(' ', $month);
        $date = new \DateTime('1st '.$month.' '.$year);
        $month = $date->format('m');

        return Period::createFromMonth($year, $month);
    }

    /**
     * @Transform :date
     */
    public function castDateStringToDate($date)
    {
        return new \DateTimeImmutable($date);
    }
}
