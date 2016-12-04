<?php

namespace Milhojas\Domain\Cantine;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Prophecy\Prophet;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Library\ValueObjects\Identity\PersonName;
use Milhojas\Library\Collections\Checklist;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;

/**
 * Defines application features from the specific context.
 */
class BuyingTicketsContext implements Context
{
    private $prophet;
    private $student;
    private $cantineUser;
    private $CantineUserRepository;
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
        $this->CantineUserRepository = new CantineUserInMemoryRepository();
        $this->TicketRepository = $this->prophet->prophesize(TicketRepository::class);
        $this->TicketRegistrar = $this->prophet->prophesize(TicketRegistrar::class);
    }

    /**
     * @Given There is a Student called :student_name
     */
    public function thereIsAStudentCalled($student_name)
    {
        $this->student = $this->prophet->prophesize(Student::class);
        $this->student->getStudentId()->willReturn(new StudentId('student-01'));
        list($name, $surname) = explode(' ', $student_name);
        $this->student->getName()->willReturn(new PersonName($name, $surname));
        $this->student->getAllergies()->willReturn(new Allergens(new Checklist(['this', 'that'])));
    }

    /**
     * @Given Student is not registered as Cantine User
     */
    public function studentIsNotRegisteredAsCantineUser()
    {
        $this->cantineUser = CantineUser::apply($this->student->reveal());
    }

    /**
     * @When Student buys a ticket to eat on date :date
     */
    public function studentBuysATicketToEatOnDate($date)
    {
        $this->cantineUser->buysTicketFor(new ListOfDates([$date]));
    }

    /**
     * @Then Student should be assigned to a CantineGroup
     */
    public function studentShouldBeAssignedToACantinegroup()
    {
        $this->cantineUser->assignToGroup(new CantineGroup('Test group'));
        if (!$this->cantineUser->belongsToGroup(new CantineGroup('Test group'))) {
            throw new Exception('User was not assigned to group.');
        }
    }

    /**
     * @Then Student should be registered as Cantine User
     */
    public function studentShouldBeRegisteredAsCantineUser()
    {
        $this->CantineUserRepository->store($this->cantineUser);
    }

    /**
     * @Then A ticket for date :date should be registered
     */
    public function aTicketForDateShouldBeRegistered($date)
    {
        $this->TicketRegistrar->register(new ListOfDates([$date]));
    }

    /**
     * @Then Student should be eating on date :date
     */
    public function studentShouldBeEatingOnDate($date)
    {
        if (!$this->cantineUser->isEatingOnDate($date)) {
            throw new Exception('Cantine User is not eating on ticket date.');
        }
    }

    /**
     * @Given Student is registered as Cantine User
     */
    public function studentIsRegisteredAsCantineUser()
    {
        $this->cantineUser = CantineUser::apply($this->student->reveal());
    }

    /**
     * @When Student buys a ticket to eat on date :date that he has scheduled
     */
    public function studentBuysATicketToEatOnDateThatHeHasScheduled($date)
    {
        try {
            $this->cantineUser->buysTicketFor(new ListOfDates([$date]));
            $this->TicketRegistrar->register(new ListOfDates([$date]));
        } catch (Exception $e) {
            throw new \Exception('Checking of previous schedule has failed!');
        }
    }

    /**
     * @Then No ticket should be registered
     */
    public function noTicketShouldBeRegistered()
    {
    }

    /**
     * @Then A notification should be send
     */
    public function aNotificationShouldBeSend()
    {
        throw new PendingException();
    }

    /**
     * @When Student buys tickets to eat on dates
     */
    public function studentBuysTicketsToEatOnDates(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then Student should be eating on dates
     */
    public function studentShouldBeEatingOnDates(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then tickets should be registered for dates
     */
    public function ticketsShouldBeRegisteredForDates(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Transform :date
     */
    public function castToDate($date)
    {
        return new \DateTime($date);
    }
}
